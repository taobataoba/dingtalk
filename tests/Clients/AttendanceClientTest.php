<?php

namespace ChenDingtalk\Tests\Clients;

use PHPUnit\Framework\TestCase;
use ChenDingtalk\Tests\CreateDingtalkManager;

class AttendanceClientTest extends TestCase
{
    use CreateDingtalkManager;

    /**
     * @var \ChenDingtalk\Clients\AttendanceClient
     */
    private $client;

    public function setUp()
    {
        $this->setDingtalkManager();
        $this->client = $this->dingtalkManager->attendance();
    }

    public function userIdsProvider()
    {
        $this->setDingtalkManager();
        $response = $this->dingtalkManager->user()->getDeptMember();
        return [[$response->userIds]];
    }

    /**
     * @test
     */
    public function listSchedule()
    {
        $workDate = date('Y-m-d H:i:s');
        $response = $this->client->listSchedule($workDate);
        $this->assertEquals(0, $response->errcode);
    }

    /**
     * @test
     */
    public function getSimpleGroups()
    {
        $response = $this->client->getSimpleGroups();
        $this->assertEquals(0, $response->errcode);
    }

    /**
     * @test
     * @dataProvider userIdsProvider
     * @param array $userIds
     */
    public function listRecord($userIds)
    {
        $checkDateFrom = date('Y-m-d H:i:s', strtotime('-1 day'));
        $checkDateTo = date('Y-m-d H:i:s');
        $response = $this->client->listRecord($userIds, $checkDateFrom, $checkDateTo);
        $this->assertEquals(0, $response->errcode);
    }

    /**
     * @test
     * @dataProvider userIdsProvider
     * @param $userIdList
     */
    public function lists($userIdList)
    {
        $workDateFrom = date('Y-m-d H:i:s', strtotime('-1 day'));
        $workDateTo = date('Y-m-d H:i:s');
        $response = $this->client->lists($workDateFrom, $workDateTo, $userIdList);
        $this->assertEquals(0, $response->errcode);
    }

    /**
     * @test
     * @dataProvider userIdsProvider
     * @param $userIds
     */
    public function getLeaveApproveDuration($userIds)
    {
        $userid = array_shift($userIds);
        $from_date = date('Y-m-d H:i:s', strtotime('-1 day'));
        $to_date = date('Y-m-d H:i:s');
        $response = $this->client->getLeaveApproveDuration($userid, $from_date, $to_date);
        $this->assertEquals(0, $response->errcode);
    }

    /**
     * @test
     * @dataProvider userIdsProvider
     * @param $userid_list
     */
    public function getLeaveStatus($userid_list)
    {
        $userid_list = implode(',', $userid_list);
        $start_time = (time() - 86400) * 1000;
        $end_time = time() * 1000;
        $response = $this->client->getLeaveStatus($userid_list, $start_time, $end_time);
        $this->assertEquals(0, $response->errcode);
    }

    /**
     * @test
     * @dataProvider userIdsProvider
     * @param $userIds
     */
    public function getUserGroup($userIds)
    {
        $userid = array_shift($userIds);
        $response = $this->client->getUserGroup($userid);
        $this->assertEquals(0, $response->errcode);
    }
}