<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Actions Namespace
    |--------------------------------------------------------------------------
    |
    | Set the namespace for the Actions.
    |
    */
    'action_namespace' => 'Http\\Actions',

    /*
    |--------------------------------------------------------------------------
    | Actions Method name
    |--------------------------------------------------------------------------
    |
    | Set the method to be invoked in the actions.
    |
    */
    'action_method' => '__invoke',

    /*
    |--------------------------------------------------------------------------
    | Actions Suffix
    |--------------------------------------------------------------------------
    |
    | Set the suffix for the action.
    |
    */

    'action_suffix' => '',

    /*
    |--------------------------------------------------------------------------
    | Duplicate Suffixes
    |--------------------------------------------------------------------------
    |
    | If you have a Action suffix set in the config and try to generate a Action that also includes the suffix,
    | the package will recognize this duplication and rename the Action to remove the extra suffix.
    | This is the default behavior. To override and allow the duplication, change to false.
    |
    */
    'action_override_duplicate_suffix' => true,

    /*
    |--------------------------------------------------------------------------
    | Service Namespaces
    |--------------------------------------------------------------------------
    |
    | Set the namespace for Service classes.
    |
    */
    'service_namespace' => 'Services',

    /*
    |--------------------------------------------------------------------------
    | Autorun services
    |--------------------------------------------------------------------------
    |
    | Set to true if you want to type-hint the service in your controller and
    | have it run automatically. The request parameters will be passed to
    | the service and on to the service validator if one is defined.
    |
    */
    'service_autorun' => true,

    /*
    |--------------------------------------------------------------------------
    | Service Suffixes
    |--------------------------------------------------------------------------
    |
    | Set the suffix for the Service classes.
    |
    */
    'service_suffix' => 'Service',

    /*
    |--------------------------------------------------------------------------
    | Duplicate Suffixes
    |--------------------------------------------------------------------------
    |
    | If you have a Service suffix set in the config and try to generate a Service that also includes the suffix,
    | the package will recognize this duplication and rename the Service to remove the extra suffix.
    | This is the default behavior. To override and allow the duplication, change to false.
    |
    */
    'service_override_duplicate_suffix' => true,

    /*
    |--------------------------------------------------------------------------
    | Responder Namespace
    |--------------------------------------------------------------------------
    |
    | Set the namespace for the Responders.
    |
    */

    'responder_namespace' => 'Http\\Responders',

    /*
    |--------------------------------------------------------------------------
    | Responder Method Name
    |--------------------------------------------------------------------------
    |
    | Set the method name for the Responders.
    |
    */

    'responder_method' => 'respond',

    /*
    |--------------------------------------------------------------------------
    | Responder Syffix
    |--------------------------------------------------------------------------
    |
    | Set the syffix for the Responders.
    |
    */
    'responder_suffix' => 'Responder',

    /*
    |--------------------------------------------------------------------------
    | Responder Duplicate Suffixes
    |--------------------------------------------------------------------------
    |
    | If you have a responder suffix set in the config and try to generate a Responder that also includes the suffix,
    | the package will recognize this duplication and rename the Responder to remove the extra suffix.
    | This is the default behavior. To override and allow the duplication, change to false.
    |
     */
    'responder_override_duplicate_suffix' => true,

    /*
    |--------------------------------------------------------------------------
    | Custom Rule Namespace
    |--------------------------------------------------------------------------
    |
    | Set the namespace for custom rules.
    |
    */
    'custom_rule_namespace' => 'Rules',

    /*
    |--------------------------------------------------------------------------
    | Custom Rule Suffix
    |--------------------------------------------------------------------------
    |
    | Set the suffix to be used when generating custom rules.
    |
    */
    'custom_rule_suffix' => 'Rule',

    /*
    |--------------------------------------------------------------------------
    | Custom Rule Duplicate Suffixes
    |--------------------------------------------------------------------------
    |
    | If you have a Rule suffix set and try to generate a Rule that also includes the suffix,
    | the package will recognize this duplication and rename the Rule to remove the suffix.
    | This is the default behavior. To override and allow the duplication, change to false.
    |
    */
    'custom_rule_override_duplicate_suffix' => true,

    /*
    |--------------------------------------------------------------------------
    | Validation Service Namespace
    |--------------------------------------------------------------------------
    |
    | Set the namespace for the validation services.
    |
    */
    'validation_service_namespace' => 'Services',

    /*
    |--------------------------------------------------------------------------
    | Validation Service Suffix
    |--------------------------------------------------------------------------
    |
    | Set the suffix to be used when generating validation services.
    |
    */
    'validation_service_suffix' => 'ValidationService',

    /*
    |--------------------------------------------------------------------------
    | Validation Service Duplicate Suffixes
    |--------------------------------------------------------------------------
    |
    | If you have a Validation suffix set and try to generate a Validation that also includes the suffix,
    | the package will recognize this duplication and rename the Validation to remove the suffix.
    | This is the default behavior. To override and allow the duplication, change to false.
    |
    */
    'validation_service_override_duplicate_suffix' => true,

    /*
    |--------------------------------------------------------------------------
    | Model Baseclass
    |--------------------------------------------------------------------------
    |
    | The base or parent class of your eloquent models.
    |
    */
    'model_baseclass' => \Illuminate\Database\Eloquent\Model::class,
];
