<?php

namespace FluentFormPro\classes;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\Framework\Helpers\ArrayHelper as Arr;

class FormStylerGenerator
{

    public function generateFormCss($parentSelector, $styles)
    {
        $normalTypes = [
            'container_styles' => $parentSelector,
            'label_styles' => $parentSelector . ' .ff-el-input--label label',
            'placeholder_styles' => $parentSelector . ' .ff-el-input--content input::placeholder, ' . $parentSelector . ' .ff-el-input--content textarea::placeholder',
            'asterisk_styles' => $parentSelector . ' .asterisk-right label:after, ' . $parentSelector . ' .asterisk-left label:before',
            'inline_error_msg_style' => $parentSelector . ' .ff-el-input--content .error , ' . $parentSelector . ' .error-text',
            'success_msg_style' => $parentSelector . ' .ff-message-success',
            'error_msg_style' => $parentSelector . ' .ff-errors-in-stack '
        ];

        $cssCodes = '';
        foreach ($styles as $styleKey => $style) {
            if (isset($normalTypes[$styleKey])) {
                $cssCodes .= $this->generateNormal($style, $normalTypes[$styleKey]);
            } else if ($styleKey == 'input_styles') {
                $cssCodes .= $this->generateInputStyles($style, $parentSelector);
            } else if ($styleKey == 'sectionbreak_styles') {
                $cssCodes .= $this->generateSectionBreak($style, $parentSelector);
            } else if ($styleKey == 'gridtable_style') {
                $cssCodes .= $this->generateGridTable($style, $parentSelector);
            } else if ($styleKey == 'submit_button_style') {
                $cssCodes .= $this->generateSubmitButton($style, $parentSelector);
            } else if ($styleKey == 'radio_checkbox_style') {
                $cssCodes .= $this->generateSmartCheckable($style, $parentSelector);
            } else if ($styleKey == 'next_button_style') {
                $cssCodes .= $this->generateNextButton($style, $parentSelector);
            } else if ($styleKey == 'prev_button_style') {
                $cssCodes .= $this->generatePrevButton($style, $parentSelector);
            } else if ($styleKey == 'step_header_style') {
                $cssCodes .= $this->generateStepHeader($style, $parentSelector);
            } else if ($styleKey == 'net_promoter_style') {
                $cssCodes .= $this->generateNetPromoter($style, $parentSelector);
            } else if ($styleKey == 'range_slider_style') {
                $cssCodes .= $this->generateRangeSliderStyle($style, $parentSelector);
            }
        }

        return $cssCodes;
    }

    /*
     * For the following
     * - container_styles
     * - label_styles
     * - placeholder_styles
     * - asterisk_styles
     * - help_msg_style
     * - success_msg_style
     * - error_msg_style
     */
    public function generateNormal($styles, $selector)
    {
        $css = '';
        foreach ($styles as $styleKey => $style) {
            $css .= $this->extrachStyle($style, $styleKey, $selector);
        }
        return $css;
    }

    public function generateSectionBreak($item, $selector)
    {
        $titleStyles = Arr::get($item, 'all_tabs.tabs.LabelStyling.value');
        $titleCss = $this->generateNormal($titleStyles, '');
        if ($titleCss) {
            $titleCss = "{$selector} .ff-el-section-break .ff-el-section-title { {$titleCss} }";
        }
        $focusStyles = Arr::get($item, 'all_tabs.tabs.DescriptionStyling.value');
        $descCss = $this->generateNormal($focusStyles, '');
        if ($descCss) {
            $descCss = "{$selector} .ff-el-section-break div.ff-section_break_desk { {$descCss} }";
        }
        return $titleCss . ' ' . $descCss;
    }

    public function generateGridTable($item, $selector)
    {
        $styleSelector = $selector . ' .ff-el-input--content table.ff-table.ff-checkable-grids thead tr th';
        $theadStyles = Arr::get($item, 'all_tabs.tabs.TableHead.value');
        $normalCss = $this->generateNormal($theadStyles, '');
        if ($normalCss) {
            $normalCss = "{$styleSelector} { {$normalCss} }";
        }
        $tbodyStyles = Arr::get($item, 'all_tabs.tabs.TableBody.value');
        $tbodyCss = $this->generateNormal($tbodyStyles, '');
        if ($tbodyCss) {
            $styleDescSelector = $selector . ' .ff-el-input--content table.ff-table.ff-checkable-grids tbody tr td';
            $tbodyCss = "$styleDescSelector { {$tbodyCss} }";
        }
        return $normalCss . ' ' . $tbodyCss;
    }

    public function generateSubmitButton($style, $selector)
    {
        $stylesAllignment = $this->generateAllignment(Arr::get($style, 'allignment.value'));
        if ($stylesAllignment) {
            $stylesAllignment = "{$selector} .ff-el-group.ff_submit_btn_wrapper { {$stylesAllignment} }";
        }

        $normalStyles = Arr::get($style, 'all_tabs.tabs.normal.value', []);
        $normalCss = $this->generateNormal($normalStyles, '');
        if ($normalCss) {
            $normalCss = "{$selector} .ff_submit_btn_wrapper .ff-btn-submit { {$normalCss} }";
        }

        $hoverStyles = Arr::get($style, 'all_tabs.tabs.hover.value', []);
        $hoverCss = $this->generateNormal($hoverStyles, '');
        if ($hoverCss) {
            $hoverCss = "{$selector} .ff_submit_btn_wrapper .ff-btn-submit:hover { {$hoverCss} }";
        }

        return $stylesAllignment . $normalCss . $hoverCss;
    }

    public function generateNextButton($style, $selector)
    {
        $normalStyles = Arr::get($style, 'all_tabs.tabs.normal.value', []);
        $normalCss = $this->generateNormal($normalStyles, '');
        if ($normalCss) {
            $normalCss = "{$selector} .step-nav .ff-btn-next { {$normalCss} }";
        }

        $hoverStyles = Arr::get($style, 'all_tabs.tabs.hover.value', []);
        $hoverCss = $this->generateNormal($hoverStyles, '');
        if ($hoverCss) {
            $hoverCss = "{$selector} .step-nav .ff-btn-next:hover { {$hoverCss} }";
        }

        return $normalCss . $hoverCss;
    }

    public function generatePrevButton($style, $selector)
    {
        $normalStyles = Arr::get($style, 'all_tabs.tabs.normal.value', []);
        $normalCss = $this->generateNormal($normalStyles, '');
        if ($normalCss) {
            $normalCss = "{$selector} .step-nav .ff-btn-prev { {$normalCss} }";
        }

        $hoverStyles = Arr::get($style, 'all_tabs.tabs.hover.value', []);
        $hoverCss = $this->generateNormal($hoverStyles, '');
        if ($hoverCss) {
            $hoverCss = "{$selector} .step-nav .ff-btn-prev:hover { {$hoverCss} }";
        }

        return $normalCss . $hoverCss;
    }

    public function generateInputStyles($item, $selector)
    {
        $normalStyles = Arr::get($item, 'all_tabs.tabs.normal.value');

        $normalCss = $this->generateNormal($normalStyles, '');
        if ($normalCss) {
            $normalCss = "{$selector} .ff-el-input--content input, {$selector} .ff-el-input--content textarea, {$selector} .ff-el-input--content select, {$selector} .choices__list--single, {$selector} .choices[data-type*='select-multiple'] { {$normalCss} }";
            $borderCss = $this->extrachStyle($normalStyles['border'], 'border', '');
            if($borderCss) {
                $normalCss .= " {$selector} .frm-fluent-form .choices__list--dropdown { {$borderCss} }";
            }
        }
        $focusStyles = Arr::get($item, 'all_tabs.tabs.focus.value');
        $focusCss = $this->generateNormal($focusStyles, '');
        if ($focusCss) {
            $focusCss = "{$selector} .ff-el-input--content input:focus, {$selector} .ff-el-input--content textarea:focus, {$selector} .ff-el-input--content select:focus { {$focusCss} }";
        }
        return $normalCss . ' ' . $focusCss;

    }

    public function generateSmartCheckable($item, $selector)
    {
        $itemColor = Arr::get($item, 'color.value');

        ob_start();
        if ($itemColor) {
            ?>
            <?php echo $selector; ?> .ff-el-form-check {
            color:  <?php echo $itemColor; ?>
            }
            <?php
        }

        if (Arr::get($item, 'radio_checkbox.status') != 'yes') {
            return ob_get_clean();
        }

        $normalColor = Arr::get($item, 'radio_checkbox.value.color.value');
        $checkedColor = Arr::get($item, 'radio_checkbox.value.active_color.value');

        if (!$checkedColor) {
            $checkedColor = 'black';
        }
        if (!$normalColor) {
            $normalColor = 'black';
        }

        ?>
        <?php echo $selector; ?> input[type=checkbox] {
        -webkit-appearance: checkbox;
        }
        <?php echo $selector; ?> input[type=radio] {
        -webkit-appearance: radio;
        }
        <?php echo $selector; ?> .ff-el-group input[type=checkbox],
        <?php echo $selector; ?> .ff-el-group input[type=radio] {
        -webkit-transform: scale(1);
        transform: scale(1);
        margin-top: -4px;
        width: 23px;
        height: 10px;
        margin-right: 0px;
        cursor: pointer;
        font-size: 12px;
        position: relative;
        text-align: left;
        border: none;
        box-shadow: none;
        }
        <?php echo $selector; ?> .ff-el-group input[type=checkbox]:before,
        <?php echo $selector; ?> .ff-el-group input[type=radio]:before {
        content: none;
        }
        <?php echo $selector; ?> .ff-el-group input[type=checkbox]:after,
        <?php echo $selector; ?> .ff-el-group input[type=radio]:after {
        content: " ";
        background-color: #fff;
        display: inline-block;
        margin-left: 3px;
        padding-bottom: 3px;
        color: #212529;
        width: 15px;
        height: 15px;
        visibility: visible;
        border: 1px solid <?php echo $normalColor; ?>;
        padding-left: 1px;
        border-radius: .25rem;
        padding-top: 1px;
        -webkit-transition: all .1s ease;
        transition: all .1s ease;
        background-size: 9px;
        background-repeat: no-repeat;
        background-position: center center;
        position: absolute;
        box-sizing: border-box;
        }
        <?php echo $selector; ?> .ff-el-group input[type=checkbox]:checked:after, <?php echo $selector; ?> .ff-el-group input[type=radio]:checked:after {
        border-width: 1px;
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3E%3Cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3E%3C/svg%3E");
        background-color: <?php echo $checkedColor; ?>;
        -webkit-transition: all 0.3s ease-out;
        transition: all 0.3s ease-out;
        color: #fff;
        border-color: <?php echo $checkedColor; ?>;
        } <?php echo $selector; ?> .ff-el-group input[type=radio]:after {
        border-radius: 50%;
        font-size: 10px;
        padding-top: 1px;
        padding-left: 2px;
        } <?php echo $selector; ?> .ff-el-group input[type=radio]:checked:after {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3E%3Ccircle r='3' fill='%23fff'/%3E%3C/svg%3E");
        }
        <?php

        return ob_get_clean();
    }

    public function generateStepHeader($item, $selector)
    {
        $activeColor = Arr::get($item, 'activeColor.value');
        if (!$activeColor) {
            return '';
        }
        $inactiveColor = Arr::get($item, 'inActiveColor.value');
        $textColor = Arr::get($item, 'textColor.value');
        if (!$inactiveColor) {
            $inactiveColor = '#333';
        }
        if (!$textColor) {
            $textColor = '#fff';
        }

        $styles = "{$selector} .ff-step-titles li.ff_active:before, {$selector} .ff-step-titles li.ff_completed:before { background: {$activeColor}; color: {$textColor}; } {$selector} .ff-step-titles li.ff_active:after, {$selector} .ff-step-titles li.ff_completed:after { background: {$activeColor};} {$selector} .ff-step-titles li:after { background: {$inactiveColor};} {$selector} .ff-step-titles li:before, {$selector} .ff-step-titles li { color:  {$inactiveColor}; } {$selector} .ff-step-titles li.ff_active, {$selector} .ff-step-titles li.ff_completed { color: {$activeColor} }";
        $styles .= "{$selector} .ff-el-progress-bar { background: {$activeColor}; color: {$textColor}; } {$selector} .ff-el-progress { background-color: {$inactiveColor}; }";

        return $styles;
    }

    public function generateNetPromoter($item, $selector)
    {
        $activeColor = Arr::get($item, 'activeColor.value');
        if (!$activeColor) {
            return '';
        }
        $styles = "{$selector} .ff_net_table tbody tr td input[type=radio]:checked + label { background-color: {$activeColor}; } {$selector} .ff_net_table tbody tr td label:hover:after { border-color: {$activeColor}; }";

        return $styles;
    }

    public function generateRangeSliderStyle($item, $selector)
    {
        $activeColor = Arr::get($item, 'activeColor.value');
        if (!$activeColor) {
            return '';
        }
        $inactiveColor = Arr::get($item, 'inActiveColor.value');
        $textColor = Arr::get($item, 'textColor.value');
        if (!$inactiveColor) {
            $inactiveColor = '#e6e6e6';
        }
        if (!$textColor) {
            $textColor = '#3a3a3a';
        }

        $styles = "{$selector} .rangeslider__fill { background: {$activeColor}; } {$selector} .rangeslider { background: {$inactiveColor}; } {$selector} .rangeslider__handle { color: {$textColor}; }";

        return $styles;
    }


    public function extrachStyle($style, $styleKey, $selector)
    {
        $cssStyle = '';
        if ($styleKey == 'backgroundColor' || $styleKey == 'des_backgroundColor' || $styleKey == 'hover_backgroundColor') {
            if ($value = Arr::get($style, 'value')) {
                $cssStyle .= "background-color: {$value};";
            } else {
                return '';
            }
        } else if ($styleKey == 'color' || $styleKey == 'des_color') {
            if ($value = Arr::get($style, 'value')) {
                $cssStyle .= "color: {$value};";
            } else {
                return '';
            }
        } else if ($styleKey == 'width') {
            if ($value = Arr::get($style, 'value')) {
                $cssStyle .= "width: {$value};";
            } else {
                return '';
            }
        } else if ($styleKey == 'color_asterisk' || $styleKey == 'color_imp' || $styleKey == 'hover_color_imp') {
            if ($value = Arr::get($style, 'value')) {
                $cssStyle .= "color: {$value} !important;;";
            } else {
                return '';
            }
        } else if ($styleKey == 'margin' || $styleKey == 'padding') {
            $value = Arr::get($style, 'value');
            $cssStyle .= $this->generateAroundDimention($styleKey, $value, 'px');
        } else if ($styleKey == 'border' || $styleKey == 'hover_border') {
            if (Arr::get($style, 'value.status') != 'yes') {
                return '';
            }

            if ($borderType = Arr::get($style, 'value.border_type')) {
                $cssStyle .= 'border-style: ' . $borderType . ';';
            }
            if ($borderColor = Arr::get($style, 'value.border_color')) {
                $cssStyle .= 'border-color: ' . $borderColor . ';';
            }
            $cssStyle .= $this->generateAroundDimentionBorder(Arr::get($style, 'value.border_width'), 'px');
            $cssStyle .= $this->generateAroundDimentionBorderRadius('border', Arr::get($style, 'value.border_radius'), 'px');
        } else if ($styleKey == 'typography' || $styleKey == 'des_typography' || $styleKey == 'hover_typography') {
            $cssStyle .= $this->generateTypegraphy(Arr::get($style, 'value'));
        } else if ($styleKey == 'des_margin') {
            $cssStyle .= $this->generateAroundDimention('margin', Arr::get($style, 'value'), 'px');
        } else if ($styleKey == 'des_padding') {
            $cssStyle .= $this->generateAroundDimention('padding', Arr::get($style, 'value'), 'px');
        } else if ($styleKey == 'boxshadow' || $styleKey == 'hover_boxshadow') {
            $cssStyle .= $this->generateBoxshadow(Arr::get($style, 'value'));
        } else if ($styleKey == 'allignment') {
            $cssStyle .= $this->generateAllignment(Arr::get($style, 'value'));
        } else if ($styleKey == 'placeholder') {
            $cssStyle .= $this->generatePlaceholder(Arr::get($style, 'value'));
        }

        if ($cssStyle && $selector) {
            return $selector . '{ ' . $cssStyle . ' } ';
        }

        return $cssStyle;
    }

    public function generateAroundDimention($styleKey, $values, $unit)
    {
        if (Arr::get($values, 'linked') == 'yes') {
            $top = Arr::get($values, 'top');
            return "{$styleKey}: {$top}{$unit};";
        }
        $cssStyle = '';
        if (Arr::get($values, 'top')) {
            $value = Arr::get($values, 'top');
            $cssStyle .= "{$styleKey}-top: {$value}{$unit};";
        }
        if (Arr::get($values, 'left')) {
            $value = Arr::get($values, 'left');
            $cssStyle .= "{$styleKey}-left: {$value}{$unit};";
        }
        if (Arr::get($values, 'right')) {
            $value = Arr::get($values, 'right');
            $cssStyle .= "{$styleKey}-right: {$value}{$unit};";
        }
        if (Arr::get($values, 'bottom')) {
            $value = Arr::get($values, 'bottom');
            $cssStyle .= "{$styleKey}-bottom: {$value}{$unit};";
        }
        return $cssStyle;
    }

    public function generateAroundDimentionBorder($values, $unit)
    {
        if (Arr::get($values, 'linked') == 'yes') {
            $top = Arr::get($values, 'top');
            if ($top != '') {
                return "border-width: {$top}{$unit};";
            }
            return '';
        }
        $cssStyle = '';
        if (Arr::get($values, 'top') != '') {
            $value = Arr::get($values, 'top');
            $cssStyle .= "border-top-width: {$value}{$unit};";
        }
        if (Arr::get($values, 'left') != '') {
            $value = Arr::get($values, 'left');
            $cssStyle .= "border-left-width: {$value}{$unit};";
        }
        if (Arr::get($values, 'right') != '') {
            $value = Arr::get($values, 'right');
            $cssStyle .= "border-right-width: {$value}{$unit};";
        }
        if (Arr::get($values, 'bottom') != '') {
            $value = Arr::get($values, 'bottom');
            $cssStyle .= "border-bottom-width: {$value}{$unit};";
        }
        return $cssStyle;
    }

    public function generateAroundDimentionBorderRadius($styleKey, $values, $unit)
    {
        if (Arr::get($values, 'linked') == 'yes') {
            $top = Arr::get($values, 'top');
            return "{$styleKey}-radius: {$top}{$unit};";
        }
        $cssStyle = '';
        if (Arr::get($values, 'top')) {
            $value = Arr::get($values, 'top');
            $cssStyle .= "{$styleKey}-top-left-radius: {$value}{$unit};";
        }
        if (Arr::get($values, 'left')) {
            $value = Arr::get($values, 'left');
            $cssStyle .= "{$styleKey}-bottom-right-radius: {$value}{$unit};";
        }
        if (Arr::get($values, 'right')) {
            $value = Arr::get($values, 'right');
            $cssStyle .= "{$styleKey}-top-right-radius: {$value}{$unit};";
        }
        if (Arr::get($values, 'bottom')) {
            $value = Arr::get($values, 'bottom');
            $cssStyle .= "{$styleKey}-bottom-left-radius: {$value}{$unit};";
        }
        return $cssStyle;
    }

    public function generateTypegraphy($values)
    {

        $styles = '';
        if (Arr::get($values, 'fontSize.value') != '') {
            $sizeUnit = Arr::get($values, 'fontSize.type', 'px');
            $fontSize = Arr::get($values, 'fontSize.value');
            $styles .= "font-size: {$fontSize}{$sizeUnit};";
        }
        if ($value = Arr::get($values, 'fontWeight')) {
            $styles .= "font-weight: {$value};";
        }
        if ($value = Arr::get($values, 'transform')) {
            $styles .= "text-transform: {$value};";
        }
        if ($value = Arr::get($values, 'fontStyle')) {
            $styles .= "font-style: {$value};";
        }
        if ($value = Arr::get($values, 'textDecoration')) {
            $styles .= "text-decoration: {$value};";
        }
        if (Arr::get($values, 'lineHeight.value') != '') {
            $sizeUnit = Arr::get($values, 'lineHeight.type', 'px');
            $lineHeight = Arr::get($values, 'lineHeight.value');
            $styles .= "line-height: {$lineHeight}{$sizeUnit};";
        }
        if (Arr::get($values, 'letterSpacing.value') != '') {
            $sizeUnit = Arr::get($values, 'letterSpacing.type', 'px');
            $spacing = Arr::get($values, 'letterSpacing.value');
            $styles .= "letter-spacing: {$spacing}{$sizeUnit};";
        }
        return $styles;
    }

    public function generateBoxshadow($values)
    {
        $color = Arr::get($values, 'color');
        if (!$color) {
            return '';
        }
        $styles = '';
        $horValue = Arr::get($values, 'horizontal.value');
        $verValue = Arr::get($values, 'vertical.value');
        $blurValue = Arr::get($values, 'blur.value');
        if ($horValue != '' && $verValue != '' && $blurValue != '') {
            $horUnit = Arr::get($values, 'values.horizontal.type', 'px');
            $verUnit = Arr::get($values, 'values.vertical.type', 'px');
            $blurUnit = Arr::get($values, 'values.blur.type', 'px');

            $spredValue = Arr::get($values, 'spread.value');
            $spredUnit = Arr::get($values, 'spread.type');
            $styles = "box-shadow: {$horValue}{$horUnit} {$verValue}{$verUnit} {$blurValue}{$blurUnit} {$spredValue}{$spredUnit}";
            $styles .= ' ' . $color;
            if (Arr::get($values, 'position') == 'inset') {
                $styles .= ' inset';
            }
            $styles .= ';';
        }
        return $styles;
    }

    public function generateAllignment($value)
    {
        if (!$value) {
            return '';
        }
        return 'text-align: ' . $value . ';';
    }

    public function generatePlaceholder($value)
    {
        if (!$value) {
            return '';
        }
        return 'color: ' . $value . ';';
    }
}