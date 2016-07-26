<?php namespace App\repo\View;

use App\Models\Info;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Laracasts\Flash\Flash;
use JavaScript;
use Activity;
use PDF;

class ViewPage {

    public $qdn;
    protected $view;

    public function display(Info $qdn, $view)
    {
        $this->qdn = $qdn->with('InvolvePerson')->first();
        $this->view = $view;

        if (Gate::allows('mod-qdn', $this->qdn->slug))
        {
            return $this->view();
        }

        return $this->redirectHome();
    }

    public function view()
    {
        $this->createJavaScriptVariables()
            ->createCache()
            ->event();

        return view($this->view, [
            'qdn' => $this->qdn
        ]);
    }

    public function createCache()
    {
        $this->hasError();

        Cache::add($this->qdn->slug, user()->employee->name, 5);

        return $this;
    }

    protected function createJavaScriptVariables()
    {
        $links = [
            'linkDraft' => route('draft_link', ['slug' => $this->qdn->slug]),
            'linkApproval' => route('approval_link', ['slug' => $this->qdn->slug])
        ];

        JavaScript::put([
            'link' => $links,
            'qdn' => $this->qdn
        ]);

        return $this;
    }

    protected function event()
    {
        Activity::log("View {$this->qdn->control_id}");

        return $this;
    }

    protected function redirectHome()
    {
        $active_user = Cache::get($this->qdn->slug);
        Flash::warning("Notice: Sorry, The page you are trying to access is currently used by {$active_user} please try again later");

        return redirect(route('home'));
    }

    protected function hasError()
    {
        if ( ! $this->qdn->involvePerson()->count())
            throw new Exception('Missing InvolvePerson table');
    }

    public function deleteCache()
    {
        if (Gate::allows('mod-qdn', $this->qdn->slug))
        {
            Cache::forget($this->qdn->slug);
        }
    }

    public static function PDF(Info $qdn)
    {
        Activity::log("Download QDN {$qdn->control_id } : {$qdn->discrepancy_category}");

        return PDF::loadHTML(view('pdf.print', ['qdn' => $qdn]))->stream();
    }
}