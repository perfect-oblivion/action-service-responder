<?php

namespace PerfectOblivion\ActionServiceResponder\Payload\Contracts;

interface Status
{
    const STATUS_CONTINUE = 100;                               // Continue
    const STATUS_SWITCHING_PROTOCOLS = 101;                    // Switching Protocols
    const STATUS_PROCESSING = 102;                             // Processing
    const STATUS_OK = 200;                                     // OK
    const STATUS_CREATED = 201;                                // Created
    const STATUS_ACCEPTED = 202;                               // Accepted
    const STATUS_NON_AUTHORITATIVE_INFORMATION = 203;          // Non-Authoritative Information
    const STATUS_NO_CONTENT = 204;                             // No Content
    const STATUS_RESET_CONTENT = 205;                          // Reset Content
    const STATUS_PARTIAL_CONTENT = 206;                        // Partial Content
    const STATUS_MULTI_STATUS = 207;                           // Multi-Status
    const STATUS_ALREADY_REPORTED = 208;                       // Already Reported
    const STATUS_IM_USED = 226;                                // IM Used
    const STATUS_MULTIPLE_CHOICES = 300;                       // Multiple Choices
    const STATUS_MOVED_PERMANENTLY = 301;                      // Moved Permanently
    const STATUS_FOUND = 302;                                  // Found
    const STATUS_SEE_OTHER = 303;                              // See Other
    const STATUS_NOT_MODIFIED = 304;                           // Not Modified
    const STATUS_USE_PROXY = 305;                              // Use Proxy
    const STATUS_TEMPORARY_REDIRECT = 307;                     // Temporary Redirect
    const STATUS_PERMANENT_REDIRECT = 308;                     // Permanent Redirect
    const STATUS_BAD_REQUEST = 400;                            // Bad Request
    const STATUS_UNAUTHORIZED = 401;                           // Unauthorized
    const STATUS_PAYMENT_REQUIRED = 402;                       // Payment Required
    const STATUS_FORBIDDEN = 403;                              // Forbidden
    const STATUS_NOT_FOUND = 404;                              // Not Found
    const STATUS_METHOD_NOT_ALLOWED = 405;                     // Method Not Allowed
    const STATUS_NOT_ACCEPTABLE = 406;                         // Not Acceptable
    const STATUS_PROXY_AUTHENTICATION_REQUIRED = 407;          // Proxy Authentication Required
    const STATUS_REQUEST_TIMEOUT = 408;                        // Request Timeout
    const STATUS_CONFLICT = 409;                               // Conflict
    const STATUS_GONE = 410;                                   // Gone
    const STATUS_LENGTH_REQUIRED = 411;                        // Length Required
    const STATUS_PRECONDITION_FAILED = 412;                    // Precondition Failed
    const STATUS_PAYLOAD_TOO_LARGE = 413;                      // Payload Too Large
    const STATUS_URI_TOO_LONG = 414;                           // URI Too Long
    const STATUS_UNSUPPORTED_MEDIA_TYPE = 415;                 // Unsupported Media Type
    const STATUS_RANGE_NOT_SATISFIABLE = 416;                  // Range Not Satisfiable
    const STATUS_EXPECTATION_FAILED = 417;                     // Expectation Failed
    const STATUS_IM_A_TEAPOT = 418;                            // I'm a teapot
    const STATUS_MISDIRECTED_REQUEST = 421;                    // Misdirected Request
    const STATUS_UNPROCESSABLE_ENTITY = 422;                   // Unprocessable Entity
    const STATUS_LOCKED = 423;                                 // Locked
    const STATUS_FAILED_DEPENDENCY = 424;                      // Failed Dependency
    const STATUS_UPGRADE_REQUIRED = 426;                       // Upgrade Required
    const STATUS_PRECONDITION_REQUIRED = 428;                  // Precondition Required
    const STATUS_TOO_MANY_REQUESTS = 429;                      // Too Many Requests
    const STATUS_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;        // Request Header Fields Too Large
    const STATUS_CONNECTION_CLOSED_WITHOUT_RESPONSE = 444;     // Connection Closed Without Response
    const STATUS_UNAVAILABLE_FOR_LEGAL_REASONS = 451;          // Unavailable For Legal Reasons
    const STATUS_CLIENT_CLOSED_REQUEST = 499;                  // Client Closed Request
    const STATUS_INTERNAL_SERVER_ERROR = 500;                  // Internal Server Error
    const STATUS_NOT_IMPLEMENTED = 501;                        // Not Implemented
    const STATUS_BAD_GATEWAY = 502;                            // Bad Gateway
    const STATUS_SERVICE_UNAVAILABLE = 503;                    // Service Unavailable
    const STATUS_GATEWAY_TIMEOUT = 504;                        // Gateway Timeout
    const STATUS_VERSION_NOT_SUPPORTED = 505;                  // HTTP Version Not Supported
    const STATUS_VARIANT_ALSO_NEGOTIATES = 506;                // Variant Also Negotiates
    const STATUS_INSUFFICIENT_STORAGE = 507;                   // Insufficient Storage
    const STATUS_LOOP_DETECTED = 508;                          // Loop Detected
    const STATUS_NOT_EXTENDED = 510;                           // Not Extended
    const STATUS_NETWORK_AUTHENTICATION_REQUIRED = 511;        // Network Authentication Required
    const STATUS_NETWORK_CONNECT_TIMEOUT_ERROR = 599;          // Network Connect Timeout Error
}
