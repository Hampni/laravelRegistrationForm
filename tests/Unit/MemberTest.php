<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Requests\AddNewMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Faker\Factory as Faker;

class MemberTest extends TestCase
{
    
    use RefreshDatabase;

    protected $memberController;

    protected $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->memberController = $this->app->make('App\Http\Controllers\Api\MemberController');

        $this->faker = Faker::create();
    }

    public function test_return_members_only_permitet_to_be_shown()
    {
        //create fake members
        Member::factory(10)->create();

        //request only shown members
        $members = $this->memberController->getShownMembers();

        //assert that returned only permited to be shown members
        collect($members)->each(fn ($member) => $this->assertTrue($member['is_shown'] == '1'));
    }

    public function test_return_all_members_both_permitet_to_be_shown_and_not()
    {
        //create fake members both to be shown and not
        Member::factory(5)->create(['is_shown' => '1']);
        Member::factory(5)->create(['is_shown' => '0']);

        //request all members
        $members = $this->memberController->getAllMembers();

        //assert that returned both to be shown and not members
        collect($members)->each(fn ($member) => $this->assertTrue($member['is_shown'] == '1' || $member['is_shown'] == '0'));
    }

    public function test_only_one_member_returned_by_id()
    {
        $id = 4;

        //create fake member
        Member::factory($id)->create();

        //request this member
        $member = $this->memberController->getOneMember($id);
        $memberId = collect($member)->all()[0]['id'];

        //assert id of the returned member
        $this->assertEquals($id, $memberId);
    }

    public function test_count_members_returned_right_number()
    {
        $amount = 24;

        //create some fake number of members
        Member::factory($amount)->create();

        //request to count members
        $numberOfMembers = $this->memberController->countMembers();

        //assert number of members is equal to crated amount
        $this->assertEquals($amount, $numberOfMembers);
    }

    public function test_switch_to_hide_member()
    {
        //create fake request
        $request = new Request();
        $request->setMethod('POST');
        $request->request->add(['id' => '1', 'change' => '0']);

        //create fake member that is now shown
        Member::factory()->create(['is_shown' => '1']);
    
        //request to hide this member
         $memberDisplayStatus = $this->memberController->changeDisplay($request);
        
        //assert that member is now hiden
        $this->assertEquals('0', $memberDisplayStatus);
    }

    public function test_switch_to_displays_member()
    {     
        //create fake request
        $request = new Request();
        $request->setMethod('POST');
        $request->request->add(['id' => '1', 'change' => '1']);

        //create fake member that is not shown now
        $memberNotShown = Member::factory()->create(['is_shown' => '0']);

        //request to display this member
        $memberDisplayStatus = $this->memberController->changeDisplay($request);

        //assert that member is shown
        $this->assertEquals('1', $memberDisplayStatus);
    }

    public function test_add_new_member_from_admin_panel()
    {

        //create fake member
        $newMember = collect(Member::factory()->make());

        //create new add member request
        $addNewMemberRequest = new AddNewMemberRequest();
        $addNewMemberRequest->setMethod('POST');
        $addNewMemberRequest->request->add($newMember->toArray());

        //add new member
        $this->memberController->addMember($addNewMemberRequest);

        //assert that the new member was added successfully
        $this->assertDatabaseHas('members', [
            'first_name' => $newMember['first_name'],
            'email' => $newMember['email'],
            'country' => $newMember['country'],
        ]);
    }

    public function test_update_member_from_admin_panel()
    {

        $id = 4;

        //create fake new member
        Member::factory($id)->create();

        //data to update
        $dataToUpdate = [
            'id' => $id,
            'first_name' => $this->faker->firstName(),
            'email' => $this->faker->email(),
        ];

        //create update request
        $ubdateMemberRequest = new UpdateMemberRequest();
        $ubdateMemberRequest->setMethod('POST');
        $ubdateMemberRequest->request->add($dataToUpdate);

        //update existed member
        $this->memberController->updateMember($ubdateMemberRequest);

        //assert member was updated
        $this->assertDatabaseHas('members', [
            'id' => $id,
            'first_name' => $dataToUpdate['first_name'],
            'email' => $dataToUpdate['email']
        ]);
    }

    public function test_member_delete()
    {
        $id = 7;

        //create fake member
        Member::factory($id)->create();

        //creake delete request
        $deleteRequest = new Request();
        $deleteRequest->setMethod('DELETE');
        $deleteRequest->request->add(['id' => $id]);

        //delete member
        $this->memberController->deleteMember($deleteRequest);

        //assert it was deleted successfully
        $this->assertDatabaseMissing('members', ['id' => $id]);
    }

    public function test_delete_photo()
    {
        $photo = 'default.png'; //delete -> change to default

        //create fake member
        Member::factory()->create(['photo' => 'someting.jpg']);

        //creake delete request
        $deletePhotoRequest = new Request();
        $deletePhotoRequest->setMethod('DELETE');
        $deletePhotoRequest->request->add(['id' => '1', 'photo' => $photo]);

        //delete member
        $this->memberController->deletePhoto($deletePhotoRequest);

        //assert it was deleted successfully
        $this->assertDatabaseHas('members', ['id' => '1', 'photo' => $photo]);
    }

}

