<?php
namespace FluentFormPro\classes;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Modules\Entries\Report;
use FluentForm\App\Modules\Form\FormFieldsParser;

class SurveyResultProcessor
{
    public function getSurveyResultHtml($attributes)
    {
        $attributes = wp_parse_args($attributes, array(
            'form_id'    => null,
            'field_name' => '',
            'label'      => 'yes',
            'counts'     => 'yes'
        ));
        if (empty($attributes['form_id'])) {
            return '';
        }

        $form = wpFluent()->table('fluentform_forms')->find($attributes['form_id']);

        if (!$form) {
            return '';
        }

        $reportingFields = $this->getReportableFields($form, $attributes['field_name']);

        $reportClass = new Report(wpFluentForm());
        $reports = $reportClass->getInputReport($form->id, array_keys($reportingFields), []);

        $formattedReports = [];
        foreach ($reports as $reportKey => $report) {
            $formattedValues = [];

            $options = $reportingFields[$reportKey]['options'];;


            foreach ($report['reports'] as $reportItem) {
                $reportItem['percent'] = round( ($reportItem['count'] / $report['total_entry']) * 100);
                if (isset($options[$reportItem['value']])) {
                    $itemKey = $reportItem['value'];
                    $reportItem['value'] = $options[$itemKey];
                    $formattedValues[$itemKey] = $reportItem;
                }
            }

            $shotableArray = array_intersect(array_keys($options), array_keys($formattedValues));

            $formattedValues = array_replace(array_flip($shotableArray), $formattedValues);

            $formattedValues = array_filter($formattedValues, 'is_array');

            $report['reports'] = $formattedValues;
            $report['label'] = $reportingFields[$reportKey]['label'];
            $report['options'] = $options;
            $report['element'] = $reportingFields[$reportKey]['element'];
            $formattedReports[$reportKey] = $report;
        }



        $reportHtml = '<div class="ff_poll_wrapper">';
        foreach ($formattedReports as $formattedReport) {
            $reportHtml .= $this->getGereratedReortHtml($formattedReport, $attributes['label'], $attributes['counts'], $form);
        }
        $reportHtml .= '</div>';

        $css = $this->getPollCss();
        return  $css.$reportHtml;

    }

    public function getReportableFields($form, $reportFieldName)
    {

        $reportFieldNames = explode(',', $reportFieldName);

        $fields = FormFieldsParser::getInputs($form, ['element', 'options', 'label']);
        $reportableFields = Helper::getReportableInputs();
        $reportableItems = [];

        foreach ($fields as $fieldName => $field) {
            if ($field['element'] == 'select_country') {
                $field['options'] = getFluentFormCountryList();
            }
            if (in_array($field['element'], $reportableFields) && !empty($field['options'])) {
                $reportableItems[$fieldName] = $field;
            }
        }

        if (!$reportFieldName) {
            return $reportableItems;
        }

        $returnItems = [];
        foreach ($reportFieldNames as $reportFieldName) {
            if (isset($reportableItems[$reportFieldName])) {
                $returnItems[$reportFieldName] = $reportableItems[$reportFieldName];
            }
        }

        return $returnItems;
    }

    public function getGereratedReortHtml($data, $showLabel = 'yes', $showCount = 'yes', $form)
    {
        $showLabel = $showLabel == 'yes';
        $showCount = $showCount == 'yes';
        ob_start();
        ?>
        <div class="ff_poll_result ff_poll_<?php echo $data['element']; ?>">
            <?php if ($showLabel): ?>
                <div class="ff-poll-label"><?php echo $data['label']; ?></div>
            <?php endif; ?>
            <?php foreach ($data['reports'] as $report): ?>
                <div class="ff-poll-answer">
                    <div class="ff-poll-answer-label-wrap">
                        <div class="ff-poll-answer-percent">
                            <span><?php echo $report['percent']; ?>%</span>
                            <?php if($showCount):  ?>
                            <div class="ff-poll-answer-count">(<?php echo $report['count']; ?> votes)</div>
                            <?php endif; ?>
                        </div>
                        <div class="ff-poll-answer-label"><?php echo $report['value']; ?></div>
                    </div>
                    <div class="ff-poll-answer-bar-wrap">
                        <div class="ff-poll-answer-bar" style="width:<?php echo $report['percent']; ?>%;"></div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if($showCount): ?>
                <div class="ff-poll-total">Total Votes: <?php echo $data['total_entry']; ?></div>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }

    public function getPollCss()
    {
        ob_start();
        ?>
        <style type="text/css">
            .ff_poll_wrapper .ff_poll_result {
                background-color: #f7fafc;
                border: 1px solid #e3e8ee;
                margin: 26px 0;
                padding: 20px
            }

            .ff_poll_result .ff-poll-label {
                text-align: center;
                font-weight: 700;
                font-size: 18px;
                margin: 15px 0 0
            }

            .ff_poll_result .ff-poll-answer {
                margin: 15px 0
            }

            .ff_poll_result .ff-poll-answer-label-wrap {
                overflow: hidden
            }

            .ff_poll_result .ff-poll-answer-label {
                font-size: 16px;
                color: #333;
                margin-right: 150px
            }

            .ff_poll_result .ff-poll-answer-percent {
                font-size: 14px;
                color: #333;
                float: right
            }

            .ff_poll_result .ff-poll-answer-count {
                display: inline;
                color: #999
            }

            .ff_poll_result .ff-poll-answer-bar-wrap {
                height: 20px;
                position: relative;
                background-color: #e9ecef;
                border-radius: 4px;
            }

            .ff_poll_result .ff-poll-answer-bar {
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                background-image: linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);
                background-size: 1rem 1rem;
                white-space: nowrap;
                background-color: #007bff;
                transition: width .6s ease;
                border-radius: 4px;
            }

            .ff_poll_result .ff-poll-total {
                font-size: 18px;
                text-align: center;
                margin: 0 0 15px 0
            }
        </style>
        <?php
        return ob_get_clean();
    }

}