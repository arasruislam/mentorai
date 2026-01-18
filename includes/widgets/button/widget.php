<?php
namespace MentorAI\Widgets\Button;

use MentorAI\Widgets\_Shared\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget extends Base_Widget {

    public function get_name() {
        return 'mentorai-button';
    }

    public function get_title() {
        return __( 'MentorAI Button', 'mentorai' );
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        // আপনার categories-manager.php যেটা রেজিস্টার করে (যেমন 'mentorai')
        return [ 'mentorai' ];
    }

    public function get_style_depends() {
        return [ 'mentorai-button' ];
    }

    protected function register_controls() {
        require __DIR__ . '/controls.php';
        Controls::register( $this );
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        require __DIR__ . '/view.php';
    }
}
