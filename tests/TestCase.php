
<?php
use App\User;
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
        $this->actingAs(User::whereEmployeeId(802)->first());

        return $this;
    }

    /**
     * @return mixed
     */
    protected function loginAsAdmin()
    {
        $this->actingAs(User::whereEmployeeId(801)->first());
        return $this;
    }
}
