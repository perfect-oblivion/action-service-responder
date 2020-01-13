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
