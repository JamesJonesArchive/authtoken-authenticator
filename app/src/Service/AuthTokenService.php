<?php

/**
 * Copyright 2015 University of South Florida
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 **/

namespace USF\IdM\AuthTransfer\AuthToken\Service;

use Psr\Log\LoggerInterface;
use Slim\Collection;
use Firebase\JWT\JWT;
use Ramsey\Uuid\Uuid;

/**
 * Web Token Service
 *
 * @category usf-it
 * @package webtoken-authenticator
 * @author Eric Pierce <epierce@usf.edu>
 * @author James Jones <james@mail.usf.edu>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @link https://github.com/USF-IT/webtoken-authenticator
 */
class AuthTokenService implements \USF\IdM\AuthTransfer\AuthTransferServiceInterface {
    private $logger;
    private $settings;

    public function __construct(LoggerInterface $logger, Collection $settings )
    {
        $this->logger = $logger;
        $this->settings = $settings;

        // Pull config data from the settings object
        //$serviceConfig = $settings['example_config'];

        // If you need to configure your service object, do it here and  add it as a
        // private property to the class.
    }

    
    public function findApplicationinRegistry($appId) {
        $application = \array_filter($this->settings['webtoken']['appRegistry'], function($r) use($appId) {
            if(!isset($r['id'])) {
                return false;
            } else if(\substr($r['id'], 0, 1) == '^') {
                return \boolval(\preg_match('/'.$r['id'].'/',$appId));                
            } else {
                return ($r['id'] == $appId);
            }
        });
        return (\count($application) < 1)?$application:\array_shift($application);
    }
    
    public function isValidUrl($url) {
        return \boolval(\count(\array_filter($this->settings['webtoken']['validUrlPatterns'], function($p) use($url) {
            return \boolval(\preg_match('/'.$p.'/', $url));
        })));
    }
    
    public function getSignedToken($application,$username,$extraAttributes) {
        $issuedAt   = \time();
        $notBefore  = $issuedAt;                  // Not Adding any seconds
        $expire     = $notBefore + (60 * 60);     // Set expiration in 60 minutes
        return JWT::encode(
            \array_merge(
                $extraAttributes,
                [
                    'iat'  => $issuedAt,                                   // Issued at: time when the token was generated
                    'jti'  => Uuid::uuid4()->toString(),                   // Json Token Id: an unique identifier for the token
                    'iss'  => $this->settings['webtoken']['issuer'],       // Issuer
                    'nbf'  => $notBefore,                                  // Not before
                    'exp'  => $expire,                                     // Expire
                    'aud'  => [ $application['id'] ],                      // Audience using the AppId
                    'sub'  => $username,                                   // Subject using the CAS username
                    'data' => $extraAttributes                             // Data related to the signer user
                ]
            ),                                                         //Data to be encoded in the JWT
            $application['sharedSecret'],                              // The signing key
            $this->settings['webtoken']['signingAlgorithm']            // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
        );
        
    }

    public function getRedirectUrl($paramMap) {
        return '';
    }

}
