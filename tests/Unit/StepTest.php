<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory as Faker;
use App\Http\Requests\FirstStepRequest;
use App\Http\Requests\SecondStepRequest;

class StepTest extends TestCase
{

    use RefreshDatabase;

    protected $stepController;

    protected $faker;

    protected $firstStepMember;

    protected $secondStepMember;

    protected $firstStepRequest;


    public function setUp(): void
    {
        parent::setUp();

        $this->stepController = $this->app->make('App\Http\Controllers\Api\StepController');

        $this->faker = Faker::create();

        $this->firstStepMember = [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'birthday' => $this->faker->date(),
            'report_subject' => $this->faker->sentence(3),
            'country' => $this->faker->country(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
        ];

        $this->secondStepMember = [
            'email' => $this->faker->email(),
            'company' => $this->faker->company(),
            'position' => $this->faker->word(),
            'about_me' => $this->faker->sentence(5),
            'photo' => 'default.png',
        ];

        $this->firstStepRequest = new FirstStepRequest();
        $this->firstStepRequest->setMethod('POST');
        $this->firstStepRequest->request->add($this->firstStepMember);
    }

    public function test_data_inserted_into_database_after_first_step()
    {
        //send request to api with data from first step
        $this->stepController->firstStep($this->firstStepRequest);

        //assert if it exists in database
        $this->assertDatabaseHas('members', [
            'first_name' => $this->firstStepMember['first_name'],
            'last_name' => $this->firstStepMember['last_name'],
        ]);
    }

    public function test_user_updated_after_sending_second_step()
    {

        //send request to api with data from first step
        $this->stepController->firstStep($this->firstStepRequest);

        //create second step request
        $secondStepRequest = new SecondStepRequest();
        $secondStepRequest->setMethod('POST');
        $secondStepRequest->request->add($this->secondStepMember);

        //send request to api with data from second step
        $this->stepController->secondStep($secondStepRequest);

        //assert if it was updated
        $this->assertDatabaseHas('members', [
            'first_name' => $this->firstStepMember['first_name'],
            'position' => $this->secondStepMember['position'],
        ]);
    }

    public function test_first_step_validation_is_working()
    {
        $url = route('first_step');

        //send request to api with data from first step
        $response = $this->call('POST', $url, $this->firstStepMember);

        //assert validation not detected violation
        $response->assertSessionDoesntHaveErrors([
            'first_name',
            'last_name',
            'birthday',
            'report_subject',
            'country',
            'phone',
            'email'
        ]);

        //now sending wrong data
        $wrongData = $this->firstStepMember;
        $wrongData['first_name'] = '///:::{}{}{}'; //prohibited symbols

        //send request to api with invalid data from first step
        $response = $this->call('POST', $url, $wrongData);

        //assert validation detected violation
        $response->assertSessionHasErrors([
            'first_name'
        ]);
    }

    public function test_second_step_validation_is_working()
    {
        $url = route('second_step');

        //send request to api with data from second step
        $response = $this->call('POST', $url, $this->secondStepMember);

        //assert validation not detected violation
        $response->assertSessionDoesntHaveErrors([
            'email',
            'company',
            'position',
            'about_me',
            'photo'
        ]);

        //now sending wrong data
        $wrongData = $this->secondStepMember;
        $wrongData['company'] = '///:::{}{}{}'; //prohibited symbols

        //send request to api with invalid data from second step
        $response = $this->call('POST', $url, $wrongData);

        //assert validation detected violation
        $response->assertSessionHasErrors([
            'company'
        ]);
    }
}
