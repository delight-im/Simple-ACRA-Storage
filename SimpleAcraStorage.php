<?php

/**
 * Copyright 2015 delight.im <info@delight.im>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once(__DIR__.'/libs/JavaCrashId/JavaCrashId.php');

class SimpleAcraStorage {

    const FOLDER_NAME_FORMAT = 'logs/%1$s/%2$s/%3$s';
    const FILE_NAME_FORMAT = '%1$s %2$s.json';
    const TIME_FORMAT = 'Y-m-d H.i.s';
    const HEADER_CONTENT_TYPE = 'Content-type: text/plain; charset=utf-8';

    public static function init($timezone) {
        ignore_user_abort(true);
        date_default_timezone_set($timezone);

        header(self::HEADER_CONTENT_TYPE);
    }

    public static function generateFileName() {
        $time = date(self::TIME_FORMAT);
        $hash = md5(uniqid('', true));
        return sprintf(self::FILE_NAME_FORMAT, $time, $hash);
    }

    public static function createReport($request) {
        return json_encode($request, JSON_PRETTY_PRINT);
    }

    public static function createDirectory($name) {
        if (is_dir($name)) {
            return true;
        }
        else {
            return mkdir($name, 0750, true);
        }
    }

    public static function createFolderName($request) {
        if (empty($request['PACKAGE_NAME'])) {
            echo 'Missing package name in crash report';
            return false;
        }

        if (empty($request['APP_VERSION_CODE'])) {
            echo 'Missing app version code in crash report';
            return false;
        }

        if (empty($request['STACK_TRACE'])) {
            echo 'Missing stack trace in crash report';
            return false;
        }

        $packageName = self::sanitizeCrashBucket($request['PACKAGE_NAME']);
        $versionId = self::sanitizeCrashBucket($request['APP_VERSION_CODE']);
        $crashId = JavaCrashId::from($request['STACK_TRACE']);

        return sprintf(self::FOLDER_NAME_FORMAT, $packageName, $versionId, $crashId);
    }

    private static function sanitizeCrashBucket($name) {
        return preg_replace('/[^\w]+/', '_', trim($name));
    }

}
