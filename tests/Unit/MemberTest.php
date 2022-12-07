<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Member;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_return_members_only_permitet_to_be_shown()
    {
        //create fake members
        Member::factory(10)->create();

        //request only shown members
        $response = $this->get('/api/members');

        //assert response status
        $members = $response->assertStatus(200)->json('data');

        //assert that returned only permited to be shown members
        collect($members)->each(fn ($member) => $this->assertTrue($member['is_shown'] == '1'));
    }

    public function test_return_all_members_both_permitet_to_be_shown_and_not()
    {
        //create fake members both to be shown and not
        Member::factory(5)->create(['is_shown' => '1']);
        Member::factory(5)->create(['is_shown' => '0']);

        //request all members
        $response = $this->get('/api/members/all');

        //check response status
        $members = $response->assertStatus(200)->json('data');

        //assert that returned both to be shown and not members
        collect($members)->each(fn ($member) => $this->assertTrue($member['is_shown'] == '1' || $member['is_shown'] == '0'));
    }

    public function test_only_one_member_returned_by_id()
    {
        //create fake member
        Member::factory()->create();

        //request this member
        $response = $this->get('/api/members/one/' . 1);

        //check response status
        $response->assertStatus(200);
        $member = $response['data'][0];

        $this->assertEquals('1', $member['id'],);
    }

    public function test_count_members_returned_right_number()
    {
        $amount = 24;

        //create some fake number of members
        Member::factory($amount)->create();

        //request to count members
        $response = $this->get('/api/members/countMembers');

        //assert response status
        $numberOfMembers = $response->assertStatus(200)->json();
        
        //assert number of members is equal to crated amount
        $this->assertEquals($amount, $numberOfMembers);
    }

    public function test_switch_to_hide_member()
    {
        //create fake member that is now shown
        $memberShown = Member::factory()->create(['is_shown' => '1']);

        //request to hide member
        $responseHiden = $this->call('POST', '/api/members/changeDisplay', ['id' => '1', 'change' => '0']);
          
        //assert response stauts
        $memberDisplayStatus = $responseHiden->assertStatus(200)->json();
        
        //assert that member is hiden
        $this->assertEquals($memberDisplayStatus, '0');
    }

    public function test_switch_to_displays_member()
    {     
        //create fake member that is not shown now
        $memberNotShown = Member::factory()->create(['is_shown' => '0']);

        //request to display member
        $responseShown = $this->call('POST', '/api/members/changeDisplay', ['id' => '1', 'change' => '1']);
        
        //assert response stauts
        $memberDisplayStatus = $responseShown->assertStatus(200)->json();

        //assert that member is shown
        $this->assertEquals($memberDisplayStatus, '1');
    }

}

