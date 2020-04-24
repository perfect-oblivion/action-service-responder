# Changelog

All notable changes to PerfectOblivion/Actions will be documented in this file

## 0.0.1 - 2019-12-16

-   initial release


## 0.0.2 - 2019-12-18

-   README updated.
-   Github actions used for testing.

## 0.0.3 - 2019-12-20

-   Make route parameters available on the Service, if there are any.

## 0.0.4 - 2019-12-28

-   Make the Service class available in the Service's Validator via ```$service``` property.

## 0.0.5 - 2019-12-28

-   Service's ```$validator``` property should be "protected".

## 0.0.6 - 2019-12-31

-   Fix broken queued services.
-   Remove ability to autorun queued services.

## 0.0.7 - 2020-01-01

-   Remove FormRequests in favor of the built-in Laravel Form Requests.
-   Add a Supplementals class for handling Service supplemental parameters.

## 0.0.8 - 2020-01-02

-   Resolve ```rules()```, ```messages()```, ```filters()```, and ```attributes()``` methods from the Container.
   -   The Service supplementals are considered when resolving these methods.
-   Fix merging supplementals.
   -   Throw exception if duplicate keys detected.

## 0.0.9 - 2020-01-13

-   Make Service run method parameter array optional.
-   Add magic getter to Service.
   -   eg. If you want a 'name' property, ```$this->name```
      -   Data will be checked first, then supplementals.
   -   If your data and supplementals contain the duplicated keys, you'll still need to use the existing functionality.
      -   ```$this->getSupplementals($key);```
      -   ```$this->data[$key];```

## 0.1.0 - 2020-01-14

-   Add Service caching.
   -   To cache the result of a Service call, be sure the Service implements the CachedService interface and implement the interface methods:
      -   ```CachedService::cacheIdentifier()``` should return a unique string to be used as the cache key.
      -   ```CachedService::cacheTime()``` should return a ```DateTimeInterface```, ```DateInterval```, an integer (seconds), or null.
   -   To clear the cache, you may either use the key and clear the cache via the different ways that Laravel provides, or use the
       ```PerfectOblivion\ActionServiceProvider\Services\CacheHandler::forget($service)``` method. You may pass the name of the Service to the
       ```forget()``` method. If you have an instance of the Service, you may pass it instead of the Service name.

## 0.2.0 - 2020-03-21

-   Allow Laravel 7.0

## 0.3.0 - 2020-04-24

-   Fix autoload deprecation coming with next composer version.
   -   Move the Sanitizer Facade to Facades/.
   -   Register the sanitizer service in the package base service provider.
   -   Autoload the sanitizer facade in package composer.json.
