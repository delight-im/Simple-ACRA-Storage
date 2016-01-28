# Simple ACRA Storage

Simple storage system for crash reports from ACRA on Android

## Installation

### Server

 1. Upload the files to a public directory on your server ("target directory")
 2. Customize the [`config.php`](config.php) file
 3. Protect the `logs` directory on your server

### Android

 1. In ACRA's `@ReportsCrashes(...)` annotation, set `formUri` to the target directory
 2. Cause an unhandled exception (e.g. `String a = null; a.length();`) to test the setup

## Checking reports

 1. Go to the `logs` folder in your target directory
 2. Choose the app (by package name) and open its folder
 3. Pick one of the app versions and open its folder
 4. Sort the list of folders by size (largest first) to see the most critical bugs
 5. Open one of the folders to view the single reports for this crash

## Dependencies

 * PHP 5.3+
 * [ACRA](https://github.com/ACRA/acra)
 * [Java Crash ID](https://github.com/delight-im/Java-Crash-ID)

## Contributing

All contributions are welcome! If you wish to contribute, please create an issue first so that your feature, problem or question can be discussed.

## License

```
Copyright (c) delight.im <info@delight.im>

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
```
