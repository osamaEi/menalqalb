<?php

namespace App\Services;

class WhatsAppService 
{
    private $appId = "ZYyah4jl3QhLkNN32UCtDHA0IO57lh5tu645ULVN";
    private $appSecret = "EVBM5BtHQ7N1JkrdYjH1aEolQLZJ9x9N0wSQMY8322QHgZFmBOSvybkjcrnVMsDi053iH61RumBGJTaZXS6OpIgE8ggiOFxSCia5";
    private $projectId = 452;
    private $baseUrl = "https://api-users.4jawaly.com/api/v1/whatsapp/";
    private $namespace = "d62f7444_aa0b_40b8_8f46_0bb55ef2862e";

    /**
     * Send a WhatsApp template message with image and three body parameters
     * 
     * @param string $phoneNumber The recipient phone number
     * @param string $imageUrl The image URL to include in the header
     * @param string $bodyText1 First body text parameter
     * @param string $bodyText2 Second body text parameter  
     * @param string $bodyText3 Third body text parameter
     * @return array Response from the API
     */
    public function sendMinalqalnnewqTemplate($phoneNumber, $imageUrl, $body1, $body2, $body3)
    {
        $data = [
            "path" => "message/template",
            "params" => [
                "phone" => $phoneNumber,
                "template" => "minalqalnnewq", 
                "language" => [
                    "policy" => "deterministic",
                    "code" => "ar"
                ],
                "namespace" => $this->namespace,
                "params" => [
                    [
                        "type" => "body",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" => $body1
                            ],
                            [
                                "type" => "text",
                                "text" => $body2
                            ],
                            [
                                "type" => "text",
                                "text" => $body3
                            ]
                        ]
                    ],
                    [
                        "type" => "header",
                        "parameters" => [
                            [
                                "type" => "image",
                                "image" => [
                                    "link" => $imageUrl
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    
        return $this->makeRequest($data);
    }
    public function sendMinalqalnnewqTemplateHistory($phoneNumber, $imageUrl, $body1, $body2, $body3, $body4)
    {
        $data = [
            "path" => "message/template",
            "params" => [
                "phone" => $phoneNumber,
                "template" => "min2025", // Updated template name to match JSON
                "language" => [
                    "policy" => "deterministic",
                    "code" => "ar"
                ],
                "namespace" => "57d03f9c_7c08_46c7_9a54_f73e7a9345bf", // Updated to match JSON
                "params" => [
                    [
                        "type" => "body",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" => $body1
                            ],
                            [
                                "type" => "text",
                                "text" => $body2
                            ],
                            [
                                "type" => "text",
                                "text" => $body3
                            ],
                            [
                                "type" => "text",
                                "text" => $body4  // Fixed to use $body4 instead of repeating $body3
                            ]
                        ]
                    ],
                    [
                        "type" => "header",
                        "parameters" => [
                            [
                                "type" => "image",
                                "image" => [
                                    "link" => $imageUrl
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    
        return $this->makeRequest($data);
    }
    /**
     * Send a WhatsApp template message with image and one body parameter
     * 
     * @param string $phoneNumber The recipient phone number
     * @param string $imageUrl The image URL to include in the header
     * @param string $bodyText The body text parameter
     * @return array Response from the API
     */
    public function sendFeelingsTemplate($phoneNumber, $imageUrl, $bodyText)
    {
        $data = [
            "path" => "message/template",
            "params" => [
                "phone" => $phoneNumber,
                "template" => "feelings",
                "language" => [
                    "policy" => "deterministic",
                    "code" => "ar"
                ],
                "namespace" => $this->namespace,
                "params" => [
                    [
                        "type" => "body",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" => $bodyText
                            ]
                        ]
                    ],
                    [
                        "type" => "header",
                        "parameters" => [
                            [
                                "type" => "image",
                                "image" => [
                                    "link" => $imageUrl
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $this->makeRequest($data);
    }

    /**
     * Make a request to the WhatsApp API
     * 
     * @param array $data The data to send to the API
     * @return array Response from the API
     */
    private function makeRequest($data)
    { 
        $url = $this->baseUrl . $this->projectId; 
        
        $headers = [
            "accept: application/json",
            "Authorization: Basic " . base64_encode("$this->appId:$this->appSecret"),
            "Content-Type: application/json"
        ];
    
        // Log the request
        \Log::info('WhatsApp API Request', [
            'url' => $url,
            'data' => $data
        ]);
    
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => json_encode($data)
        ]);
    
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Log the response
        \Log::info('WhatsApp API Response', [
            'http_code' => $httpCode,
            'response' => json_decode($response, true)
        ]);
        
        if (curl_errno($ch)) {
            $result = [
                'success' => false,
                'error' => curl_error($ch)
            ];
        } else {
            $result = [
                'success' => true,
                'response' => json_decode($response, true)
            ];
        }
    
        curl_close($ch); 
        return $result;
    }
    /**
     * Send a custom WhatsApp template message
     * 
     * @param string $phoneNumber The recipient phone number
     * @param string $template The template name
     * @param string $languageCode The language code (default: ar)
     * @param array $bodyParameters Array of body parameters
     * @param array $headerParameters Array of header parameters
     * @return array Response from the API
     */
    public function sendCustomTemplate($phoneNumber, $template, $languageCode = 'ar', $bodyParameters = [], $headerParameters = [])
    {
        $params = [];
        
        if (!empty($bodyParameters)) {
            $params[] = [
                "type" => "body",
                "parameters" => $bodyParameters
            ];
        }
        
        if (!empty($headerParameters)) {
            $params[] = [
                "type" => "header",
                "parameters" => $headerParameters
            ];
        }
        
        $data = [
            "path" => "message/template",
            "params" => [
                "phone" => $phoneNumber,
                "template" => $template,
                "language" => [
                    "policy" => "deterministic",
                    "code" => $languageCode
                ],
                "namespace" => $this->namespace,
                "params" => $params
            ]
        ];

        return $this->makeRequest($data);
    }

    /**
     * Create a text parameter for a template
     * 
     * @param string $text The text to include
     * @return array The parameter array
     */
    public static function createTextParameter($text)
    {
        return [
            "type" => "text",
            "text" => $text
        ];
    }

    /**
     * Create an image parameter for a header
     * 
     * @param string $imageUrl The image URL
     * @return array The parameter array
     */
    public static function createImageParameter($imageUrl)
    {
        return [
            "type" => "image",
            "image" => [
                "link" => $imageUrl
            ]
        ];
    }
    
    /**
     * Send a simple text message (not a template)
     * 
     * @param string $phoneNumber The recipient phone number
     * @param string $message The message to send
     * @return array Response from the API
     */
    public function sendMessage($phoneNumber, $message)
    {
        $data = [
            "path" => "message/text",
            "params" => [
                "phone" => $phoneNumber,
                "message" => $message
            ]
        ];
        
        return $this->makeRequest($data);
    }

    /**
 * Get the project ID
 * 
 * @return int
 */
public function getProjectId()
{
    return $this->projectId;
}

/**
 * Get the namespace
 * 
 * @return string
 */
public function getNamespace()
{
    return $this->namespace;
}

/**
 * Get the base URL
 * 
 * @return string
 */
public function getBaseUrl()
{
    return $this->baseUrl;
}

/**
 * Get the App ID
 * 
 * @return string
 */
public function getAppId()
{
    return $this->appId;
}

/**
 * Get the App Secret
 * 
 * @return string
 */
public function getAppSecret()
{
    return $this->appSecret;
}
}