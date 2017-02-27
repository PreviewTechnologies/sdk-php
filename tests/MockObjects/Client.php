<?php
/**
 * Write something about the purpose of this file
 *
 * @author Shaharia Azam <shaharia@previewtechs.com>
 * @url https://www.previewtechs.com
 */

namespace Previewtechs\SDK\Tests\MockObjects;


class Client
{

    public function __construct()
    {

    }

    public function getMock()
    {
        $mockConfig = [
            'apiKey' => 'mock_api_key'
        ];

        $mockClient = \Mockery::mock('Previewtechs\SDK\Client');
        $mockClient->shouldReceive('setOptions')->withArgs(['apiKey' => $mockConfig['apiKey']]);
        $mockClient->shouldReceive('getOptions')->withAnyArgs()->andReturn($mockConfig['apiKey']);

        return $mockClient;
    }
}