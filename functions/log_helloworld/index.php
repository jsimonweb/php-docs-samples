<?php
/**
 * Copyright 2020 Google LLC.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

// [START functions_log_helloworld]

use Psr\Http\Message\ServerRequestInterface;

function helloLogging(ServerRequestInterface $request): string
{
    // This will be sent back as part
    // of the function's HTTP response
    print("HTTP message from print().");

    // Note: this is different than STDOUT
    // See this page for more info:
    // https://www.php.net/manual/en/wrappers.php.php
    $output = fopen('php://output', 'wb');
    fwrite($output, "HTTP message from fwrite().\n");

    // Code running in Google Cloud Functions itself
    // writes log entries to Stackdriver Logging
    // (Default log severity level is INFO.)
    $log = fopen('php://stderr', 'wb');
    fwrite($log, "Log entry from fwrite().\n");

    // You can also specify a severity level
    // explicitly using structured logs.
    // See this page for a list of log severity values:
    //   https://cloud.google.com/logging/docs/reference/v2/rest/v2/LogEntry#LogSeverity
    fwrite($log, json_encode([
      'message' => 'Structured log with error severity',
      'severity' => 'error'
    ]) . PHP_EOL);

    // This doesn't log anything
    error_log('error_log does not log in Cloud Functions!');

    return '';
}

// [END functions_log_helloworld]