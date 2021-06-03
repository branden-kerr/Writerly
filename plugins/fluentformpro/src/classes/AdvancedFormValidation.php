<?php
namespace FluentFormPro\classes;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Services\ConditionAssesor;
use FluentForm\Framework\Helpers\ArrayHelper;

class AdvancedFormValidation
{
    public function validateAdvancedConditions($errors, $data, $form, $fields)
    {
        $conditionals = $this->getAdvancedCondition($form->id);
        if(!ArrayHelper::get($conditionals, 'status')) {
            return $errors;
        }

        $isMatched = $this->checkCondition([
            'conditionals' => $conditionals
        ], $data);

        $validationType = ArrayHelper::get($conditionals, 'validation_type', 'fail_on_condition_met');

        $ifFailedOnTrue = $validationType == 'fail_on_condition_met';

        if( ($ifFailedOnTrue && $isMatched) || (!$ifFailedOnTrue && !$isMatched)) {
            $errorMessage = $conditionals['error_message'];
            if(!$errorMessage) {
                $errorMessage = __('Form validation has been failed', 'fluentformpro');
            }
            $errors['advanced_validation_error'] = $errorMessage;
        }

        return $errors;
    }

    private function getAdvancedCondition($formId)
    {
        $settingsMeta = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $formId)
            ->where('meta_key', 'advancedValidationSettings')
            ->first();

        if(!$settingsMeta || !$settingsMeta->value) {
            return false;
        }

        return \json_decode($settingsMeta->value, true);
    }

    private function checkCondition($settings, $formData)
    {
        $conditionSettings = ArrayHelper::get($settings, 'conditionals');

        if (
            !$conditionSettings ||
            !count(ArrayHelper::get($conditionSettings, 'conditions'))
        ) {
            return true;
        }

        return ConditionAssesor::evaluate($settings, $formData);
    }
}