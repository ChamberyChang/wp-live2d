<?php
/*
 * Plugin Name: Live 2D
 * Plugin URI: https://5ri.org
 * Description: 看板娘插件
 * Version: 1.7.6
 * Author: Chiang Weifang
 * Author URI: https://github.com/jiangweifang/wp-live2d
 * Text Domain: live-2d
 * Domain Path: /languages
 */


//定义目录
define( 'LIVE2D_ASSETS', plugin_dir_url( __FILE__ ) . 'assets/' );//资源目录
define('LIVE2D_LANGUAGES', basename(dirname(__FILE__)).'/languages');//基础目录

// 加载设置组件
require(dirname(__FILE__)  . '/src/live2d-Main.php');

//添加样式（初始化）

function live2D_style(){
	wp_enqueue_style( 'waifu_css' ,LIVE2D_ASSETS . "waifu.css");//css
    wp_enqueue_script( 'jquery');
    wp_enqueue_script( 'jquery-ui-draggable');
    wp_enqueue_script( 'live2dv3_core' ,'https://cubism.live2d.com/sdk-web/cubismcore/live2dcubismcore.min.js');
    wp_enqueue_script( 'live2d_js' ,LIVE2D_ASSETS.'live2d.js',array('live2dv3_core'));
	wp_enqueue_script( 'waifu-tips_js' ,LIVE2D_ASSETS.'waifu-tips.js',array('jquery-ui-draggable','live2d_js'));
}
add_action( 'get_header', 'live2D_style' );

// 启用插件
register_activation_hook( __FILE__, 'live_2d_install' );
function live_2d_install()
{
	$live_2d_Settings = new live2D_Settings();
	$live_2d_Settings -> install_Default_Settings();
	$live_2d_Settings -> install_Default_Advanced();
}

// 停用插件
register_deactivation_hook(__FILE__, 'live_2d_stop');
function live_2d_stop ()
{
	//delete_option( 'live_2d_settings_option_name' );
    //delete_option( 'live_2d_advanced_option_name' );
}

//卸载插件
register_uninstall_hook( __FILE__, 'live_2d_uninstall' );
function live_2d_uninstall(){
    delete_option( 'live_2d_settings_option_name' );
    delete_option( 'live_2d_advanced_option_name' );
}

// 设置面板设置按钮的钩子
add_filter('plugin_action_links_'.plugin_basename( __FILE__ ), 'live_2d_settings_link');
function live_2d_settings_link($links) {
    if(is_multisite() && (!is_main_site() || !is_super_admin())) return $links;
    $setlink = array(live_2d_link('options-general.php?page=live-2d-options', __('设置','live-2d')));
    return array_merge($setlink, $links);
}

function live2d_load_plugin_textdomain(){
    load_plugin_textdomain('live-2d', false, LIVE2D_LANGUAGES);
}
add_action('plugins_loaded','live2d_load_plugin_textdomain');

// 实例化设置组件
if ( is_admin() ){
	$live_2d_ = new live2D();
}

//进行设置
function live2D_DefMod(){
    // Retrieve this value with:
    $live_2d__options = get_option( 'live_2d_settings_option_name' ); // Array of All Options
    
    ?>
        <div class="waifu">
            <div class="waifu-tips"></div>
            <canvas id="live2d" class="live2d"></canvas>
            <div class="waifu-tool">
                <span class="fui-home"></span>
                <span class="fui-chat"></span>
                <span class="fui-eye"></span>
                <span class="fui-user"></span>
                <span class="fui-photo"></span>
                <span class="fui-info-circle"></span>
                <span class="fui-cross"></span>
            </div>
        </div>
        <script type="text/javascript">
        /* 判断 JQuery */
	    if($ != null){
            if (typeof($.ajax) != 'function') typeof(jQuery.ajax) == 'function' ? window.$ = jQuery : console.log('[Error] JQuery is not defined.');
        }else{
	        window.$ = jQuery;
        }
        var settings_Json = '<?php echo json_encode($live_2d__options); ?>';
        $(function(){
            initModel("<?php echo LIVE2D_ASSETS ?>waifu-tips.json",JSON.parse(settings_Json));
        });
        
        </script>
    <?php
}
add_action( 'wp_footer', 'live2D_DefMod' );




function live_2d_link($url, $text='', $ext=''){
    if(empty($text)) $text = $url;
    $button = stripos($ext, 'button') !== false ? " class='button'" : "";
    $target = stripos($ext, 'blank') !== false ? " target='_blank'" : "";
    $link = "<a href='{$url}'{$button}{$target}>{$text}</a>";
    return stripos($ext, 'p') !== false ? "<p>{$link}</p>" : "{$link} ";
}
?>
