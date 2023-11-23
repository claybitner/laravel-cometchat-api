<?php

namespace DigitalIndoorsmen\LaravelCometChatAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Message;

use Psr\Http\Message\StreamInterface;
use function json_decode;
use function mb_strtolower;

class CometChat
{
    private static $apiKey;

    private static $apiRegion;

    private static $apiVersion;

    private static $appId;

    public static $onBehalfOf;

    /**
     * CometChat Api constructor.
     */
    public function __construct($onBehalfOf = null)
    {
        self::$apiKey = config('cometchat.api_key');
        self::$apiRegion = config('cometchat.api_region');
        self::$apiVersion = config('cometchat.api_version');
        self::$appId = mb_strtolower(config('cometchat.app_id'));
        self::$onBehalfOf = $onBehalfOf;
    }

    /**
     * Create a Group
     *
     * @param  string  $password
     * @param  string  $type
     * @param  null  $icon
     * @param  null  $description
     * @param  array  $metadata
     * @param  null  $owner
     * @param  array  $tags
     * @param  array  $members
     * @param  array  $parameters
     * @return false|\Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function createGroup(
        $guid,
        $name,
        $password = null,
        $type = 'private',
        $icon = null,
        $description = null,
        $metadata = [],
        $owner = null,
        $tags = [],
        $members = [],
        $parameters = []
    ) {
        $path = '/groups';
        $method = 'POST';
        $parameters['guid'] = $guid;
        $parameters['name'] = $name;
        $parameters['type'] = $type;
        if ($password) {
            $parameters['password'] = $password;
        }
        if ($icon) {
            $parameters['icon'] = $icon;
        }
        if ($description) {
            $parameters['description'] = $description;
        }
        if ($metadata) {
            $parameters['metadata'] = $metadata;
        }
        if ($owner) {
            $parameters['owner'] = $owner;
        }
        if ($tags) {
            $parameters['tags'] = $tags;
        }
        if ($members) {
            $parameters['members'] = $members;
        }

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * List Groups
     *
     * @param  null  $searchKey
     * @param  int  $page
     * @param  array  $parameters
     * @return false|\Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function listGroups(
        $searchKey = null,
        $page = 0,
        $parameters = []
    ) {
        $path = '/groups';
        $method = 'GET';
        if ($searchKey) {
            $parameters['searchKey'] = $searchKey;
        }
        $parameters['page'] = $page;

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * Get Group
     *
     * @param  string  $guid
     * @param  array  $parameters
     * @return false|\Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getGroup(
        $guid,
        $parameters = []
    ) {
        $path = '/groups/'.$guid;
        $method = 'GET';

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * Update a Group
     *
     * @param  array  $parameters
     * @return false|\Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function updateGroup(
        $guid,
        $parameters = []
    ) {
        $path = '/groups/'.$guid;
        $method = 'PUT';

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * Delete a Group
     *
     *
     * @return false|\Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function deleteGroup(
        $guid
    ) {
        $path = '/groups/'.$guid;
        $method = 'DELETE';

        return self::sendRequest($path, $method);
    }

    /**
     * Add Group Members
     *
     * @param  array  $participants
     * @param  array  $moderators
     * @param  array  $admins
     * @param  array  $usersToBan
     * @param  array  $parameters
     * @return false|\Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function addGroupMembers(
        $guid,
        $participants = [],
        $moderators = [],
        $admins = [],
        $usersToBan = [],
        $parameters = []
    ) {
        $path = '/groups/'.$guid.'/members';
        $method = 'POST';

        if ($participants) {
            $parameters['participants'] = $participants;
        }
        if ($moderators) {
            $parameters['moderators'] = $moderators;
        }
        if ($admins) {
            $parameters['admins'] = $admins;
        }
        if ($usersToBan) {
            $parameters['usersToBan'] = $usersToBan;
        }

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * List Group Members
     *
     * @param  int  $page
     * @param  array  $parameters
     * @return false|\Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function listGroupMembers(
        $guid,
        $page = 0,
        $parameters = []
    ) {
        $path = '/groups/'.$guid.'/members';
        $method = 'GET';

        $parameters['page'] = $page;

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * Add Group Members
     *
     *
     * @return false|\Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function updateGroupMemberRole(
        $guid,
        $uid,
        $role // must be participant, moderator, admin
    ) {
        $path = '/groups/'.$guid.'/members/'.$uid;
        $method = 'PUT';

        $parameters = [];
        $parameters['guid'] = $guid;
        $parameters['uid'] = $uid;
        $parameters['scope'] = $role;

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * Remove Group Members
     *
     *
     * @return false|\Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function deleteGroupMember(
        $guid,
        $uid
    ) {
        $path = '/groups/'.$guid.'/members/'.$uid;
        $method = 'DELETE';

        return self::sendRequest($path, $method);
    }

    /**
     * Get User
     *
     * @param  string  $uid
     * @param  array  $parameters
     * @return false|\Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getUser(
        $uid,
        $parameters = []
    ) {
        $path = '/users/'.$uid;
        $method = 'GET';

        return self::sendRequest($path, $method, $parameters);
    }
    
    /**
     * Create a user
     *
     * @param    $guid
     * @param  null  $name
     * @param  array  $parameters
     * @return false|\Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function createUser(
        $uid,
        $name,
        $parameters = []
    ) {
        $path = '/users';
        $method = 'POST';
        $parameters['uid'] = $uid;
        $parameters['name'] = $name;

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * Update a user
     *
     * @param  null  $parameters
     * @return false|\Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function updateUser(
        $uid,
        $parameters = []
    ) {
        $path = '/users/'.$uid;
        $method = 'PUT';

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * Delete a user
     *
     *
     * @return \Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function deleteUser($uid)
    {
        $path = '/users/'.$uid;
        $method = 'DELETE';
        $parameters['permanent'] = true;

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * Deactivate a user
     *
     *
     * @return \Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function deactivateUser($uid)
    {
        $path = '/users/'.$uid;
        $method = 'DELETE';
        $parameters['permanent'] = false;

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * Reactivate a user or users
     *
     *
     * @return \Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function reactivateUser($uids)
    {
        $path = '/users';
        $method = 'PUT';
        $parameters['uidsToActivate'] = $uids;

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * Create a user auth token
     *
     * @param  bool  $force
     * @return \Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function createToken($uid, $force = false)
    {
        $path = '/users/'.$uid.'/auth_tokens';
        $method = 'POST';
        $parameters['force'] = $force;

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * Update a user auth token
     *
     * @param $uid
     * @param $authToken
     * @param array $parameters
     * @return StreamInterface
     *
     * @throws GuzzleException
     */
    public static function updateToken($uid, $authToken, array $parameters = [])
    {
        $path = '/users/'.$uid.'/auth_tokens/'.$authToken;
        $method = 'PUT';

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * List a user's auth tokens
     *
     * @return \Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function listTokens($uid)
    {
        $path = '/users/'.$uid.'/auth_tokens';
        $method = 'GET';

        return self::sendRequest($path, $method);
    }

    /**
     * List details of a user's auth token
     *
     * @return \Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getToken($uid, $authToken)
    {
        $path = '/users/'.$uid.'/auth_tokens/'.$authToken;
        $method = 'GET';

        return self::sendRequest($path, $method);
    }



    /**
     * Delete a user auth token
     *
     *
     * @return \Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function deleteToken($uid, $authToken)
    {
        $path = '/users/'.$uid.'/auth_tokens/'.$authToken;
        $method = 'DELETE';

        return self::sendRequest($path, $method);
    }

    /**
     * Deletes all a user's auth tokens
     *
     *
     * @return \Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function flushTokens($uid)
    {
        $path = '/users/'.$uid.'/auth_tokens';
        $method = 'DELETE';

        return self::sendRequest($path, $method);
    }

    /**
     * Block Users
     *
     *
     * @return \Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function blockUsers($uid, $blockedUsers = [])
    {
        $path = '/users/'.$uid.'/blockedusers';
        $method = 'POST';
        $parameters['blockedUids'] = $blockedUsers;

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * Unblock Users
     *
     *
     * @return \Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function unblockUsers($uid, $blockedUsers = [])
    {
        $path = '/users/'.$uid.'/blockedusers';
        $method = 'DELETE';
        $parameters['blockedUids'] = $blockedUsers;

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * Add Friends
     *
     *
     * @return \Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function addFriends($uid, $friends = [])
    {
        $path = '/users/'.$uid.'/friends';
        $method = 'POST';
        $parameters['accepted'] = $friends;

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * Delete Friends
     *
     *
     * @return \Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function deleteFriends($uid, $friends = [])
    {
        $path = '/users/'.$uid.'/friends';
        $method = 'DELETE';
        $parameters['friends'] = $friends;

        return self::sendRequest($path, $method, $parameters);
    }

    /**
     * Send a request and retrieve the response from the CometChat API
     *
     *
     * @return false|\Psr\Http\Message\StreamInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private static function sendRequest($path, $method, $data = null)
    {
        try {
            $client = new Client();
            $apiUrl = 'https://'.self::$appId.'.api-'.self::$apiRegion.'.cometchat.io/'.self::$apiVersion;

            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'apiKey' => self::$apiKey,
            ];
            if (self::$onBehalfOf && (strpos($path, 'groups') === 0)) {
                $headers['onBehalfOf'] = self::$onBehalfOf;
            }

            $response = $client->request($method, $apiUrl.$path, [
                'headers' => $headers,
                'json' => $data,
            ]);

            if ($response->getStatusCode() == '200') {
                $data = (string) $response->getBody();

                return json_decode($data);
            }

            return false;
        } catch (RequestException $e) {
            return $e->hasResponse() ? json_decode((string)$e->getResponse()->getBody()) : $e->getMessage();
        }
    }
}
