<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory as Faker;

class StepTest extends TestCase
{

    use RefreshDatabase;

    public function test_data_inserted_into_database_after_first_step()
    {
        
        $faker = Faker::create();

        //create fake user by first step example
        $member = [
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'birthday' => $faker->date(),
            'report_subject' => $faker->sentence(3),
            'country' => $faker->country(),
            'phone' => $faker->phoneNumber(),
            'email' => $faker->email(),
        ];
    
        //send request to api with data from first step
        $response = $this->call('POST', '/api/saveFirstStep', $member);

        $response->assertStatus(200);

        //assert if it exists in database
        $this->assertDatabaseHas('members', [
            'first_name' => $member['first_name'],
            'last_name' => $member['last_name'],
        ]);
    }

    public function test_user_updated_after_sending_second_step()
    {
        $faker = Faker::create();

        //create fake user by first step example
        $memberFirstStep = [
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'birthday' => $faker->date(),
            'report_subject' => $faker->sentence(3),
            'country' => $faker->country(),
            'phone' => $faker->phoneNumber(),
            'email' => $faker->email(),
        ];
    
        //send request to api with data from first step
        $this->call('POST', '/api/saveFirstStep', $memberFirstStep);

        //create fake user data by second step example
        $memberSecondStep = [
            'email' => $faker->email(),
            'company' => $faker->company(),
            'position' => $faker->word(),
            'about_me' => $faker->sentence(5),
            'photo' => 'default.png',
        ];

        //send request to api with data from second step
        $response = $this->call('POST', '/api/saveSecondStep', $memberSecondStep);

        $response->assertStatus(200);
        //assert if it was updated
        $this->assertDatabaseHas('members', [
            'first_name' => $memberFirstStep['first_name'],
            'email' => $memberSecondStep['email'],
        ]);

    }
}
