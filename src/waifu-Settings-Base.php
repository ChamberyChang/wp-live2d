<?php
class live2D_Settings_Base {

    private $live_2d__options;
    public function live_2d_settings_base_init() {

        $this->live_2d__options = get_option( 'live_2d_settings_option_name' );

        add_settings_section(
            'live_2d_setting_base_section', // id
            __('基础设置','live-2d'), // title
            array( $this, 'live_2d__section_info' ), // callback
            'live-2d-settings-base' // page
        );

        add_settings_field(
            'modelAPI', // id
            __('模型 API','live-2d'), // title
            array( $this, 'modelAPI_callback' ), // callback
            'live-2d-settings-base', // page
            'live_2d_setting_base_section' // section
        );

        add_settings_field(
            'hitokotoAPI', // id
            __('一言 API','live-2d'), // title
            array( $this, 'hitokotoAPI_callback' ), // callback
            'live-2d-settings-base', // page
            'live_2d_setting_base_section' // section
        );

        add_settings_field(
            'modelId', // id
            __('默认模型 ID','live-2d'), // title
            array( $this, 'modelId_callback' ), // callback
            'live-2d-settings-base', // page
            'live_2d_setting_base_section' // section
        );

        add_settings_field(
            'modelTexturesId', // id
            __('默认材质 ID','live-2d'), // title
            array( $this, 'modelTexturesId_callback' ), // callback
            'live-2d-settings-base', // page
            'live_2d_setting_base_section' // section
        );

        add_settings_field(
            'modelZoomNumberV2', // id
            __('模型缩放倍数','live-2d'), // title
            array( $this, 'modelZoomNumberV2_callback' ), // callback
            'live-2d-settings-base', // page
            'live_2d_setting_base_section' // section
        );

        add_settings_field(
            'aboutPageUrl', // id
            __('关于页地址','live-2d'), // title
            array( $this, 'aboutPageUrl_callback' ), // callback
            'live-2d-settings-base', // page
            'live_2d_setting_base_section' // section
        );

        add_settings_field(
            'screenshotCaptureName', // id
            __('看板娘截图文件名','live-2d'), // title
            array( $this, 'screenshotCaptureName_callback' ), // callback
            'live-2d-settings-base', // page
            'live_2d_setting_base_section' // section
        );
    }
    
    public function live_2d__section_info() {
        printf(
            '<input type="hidden" name="live_2d_settings_option_name[homePageUrl]" id="homePageUrl" value="%s">',
            get_home_url()
        );
    }

    public function modelAPI_callback() {
        printf(
            '<input class="regular-text" type="text" name="live_2d_settings_option_name[modelAPI]" id="modelAPI" value="%s">',
            isset( $this->live_2d__options['modelAPI'] ) ? esc_attr( $this->live_2d__options['modelAPI']) : ''
        );
    }

    public function hitokotoAPI_callback() {
        ?> <select name="live_2d_settings_option_name[hitokotoAPI]" id="hitokotoAPI">
            <?php $selected = (isset( $this->live_2d__options['hitokotoAPI'] ) && $this->live_2d__options['hitokotoAPI'] === 'lwl12.com') ? 'selected' : '' ; ?>
            <option <?php echo $selected; ?>>lwl12.com</option>
            <?php $selected = (isset( $this->live_2d__options['hitokotoAPI'] ) && $this->live_2d__options['hitokotoAPI'] === 'hitokoto.cn') ? 'selected' : '' ; ?>
            <option <?php echo $selected; ?>>hitokoto.cn</option>
            <?php $selected = (isset( $this->live_2d__options['hitokotoAPI'] ) && $this->live_2d__options['hitokotoAPI'] === 'jinrishici.com') ? 'selected' : '' ; ?>
            <option <?php echo $selected; ?>>jinrishici.com</option>
            <?php $selected = (isset( $this->live_2d__options['hitokotoAPI'] ) && $this->live_2d__options['hitokotoAPI'] === 'fghrsh.net') ? 'selected' : '' ; ?>
            <option <?php echo $selected; ?>>fghrsh.net</option>
        </select> <?php
    }

    public function modelId_callback() {
        printf(
            '<input class="regular-text" type="text" name="live_2d_settings_option_name[modelId]" id="modelId" value="%s">',
            isset( $this->live_2d__options['modelId'] ) ? esc_attr( $this->live_2d__options['modelId']) : ''
        );
        echo '<p>'.esc_html__('您可以在此处直接填写模型ID','live-2d').'</p>';
    }

    public function modelTexturesId_callback() {
        printf(
            '<input class="regular-text" type="text" name="live_2d_settings_option_name[modelTexturesId]" id="modelTexturesId" value="%s">',
            isset( $this->live_2d__options['modelTexturesId'] ) ? esc_attr( $this->live_2d__options['modelTexturesId']) : ''
        );
        echo '<p>'.esc_html__('您可以在此处直接填写皮肤ID','live-2d').'</p>';
    }

    public function modelZoomNumberV2_callback(){
        printf(
            '<input type="number" name="live_2d_settings_option_name[modelZoomNumberV2]" id="modelZoomNumberV2" value="%s" step="0.1" min="1.0" max="10.0" />
            <p>'.esc_html__('设置看板娘在画框中的缩放比例，最小1倍，最大10倍，可以有小数点','live-2d').'</p>',
            isset( $this->live_2d__options['modelZoomNumberV2'] ) ? esc_attr( $this->live_2d__options['modelZoomNumberV2']) : '1.0'
        );
    }

    public function aboutPageUrl_callback() {
        printf(
            '<input class="regular-text" type="text" name="live_2d_settings_option_name[aboutPageUrl]" id="aboutPageUrl" value="%s">',
            isset( $this->live_2d__options['aboutPageUrl'] ) ? esc_attr( $this->live_2d__options['aboutPageUrl']) : ''
        );
    }

    public function screenshotCaptureName_callback() {
        printf(
            '<input class="regular-text" type="text" name="live_2d_settings_option_name[screenshotCaptureName]" id="screenshotCaptureName" value="%s">',
            isset( $this->live_2d__options['screenshotCaptureName'] ) ? esc_attr( $this->live_2d__options['screenshotCaptureName']) : ''
        );
    }
}
?>