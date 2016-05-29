<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
	use DatabaseTransactions;
	/**
	 * The base URL to use while testing the application.
	 *
	 * @var string
	 */
	protected $baseUrl = 'http://qdn.me';

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__ . '/../bootstrap/app.php';

		$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

		return $app;
	}

    /**
     * @return mixed
     */
    protected function loginFakeUser()
    {
        $this->actingAs(factory(App\User::class)->create());
    }

    /**
     * @return mixed
     */
    protected function loginAsAdmin()
    {
        $user = factory(App\User::class)->create();
        $user->update(['access_level' => 'admin']);
        $this->actingAs($user);
    }
}
