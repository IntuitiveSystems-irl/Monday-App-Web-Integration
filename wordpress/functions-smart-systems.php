<?php
/**
 * Smart Systems Contact Form Handler
 * Add this code to your theme's functions.php file
 */

// Handle Smart Systems contact form submission
add_action('wp_ajax_smart_systems_contact', 'handle_smart_systems_contact');
add_action('wp_ajax_nopriv_smart_systems_contact', 'handle_smart_systems_contact');

function handle_smart_systems_contact() {
    // Verify nonce for security (optional but recommended)
    // check_ajax_referer('smart_systems_nonce', 'nonce');
    
    // Sanitize input data
    $company = sanitize_text_field($_POST['company']);
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $engagement = sanitize_text_field($_POST['engagement']);
    $message = sanitize_textarea_field($_POST['message']);
    
    // Validate email
    if (!is_email($email)) {
        wp_send_json_error('Invalid email address');
        return;
    }
    
    // Prepare email
    $to = 'info@manageonsite.com';
    $subject = 'New Smart Systems Inquiry from ' . $company;
    
    $email_body = "New inquiry from Smart Systems landing page:\n\n";
    $email_body .= "Company: " . $company . "\n";
    $email_body .= "Name: " . $name . "\n";
    $email_body .= "Email: " . $email . "\n";
    $email_body .= "Preferred Engagement: " . $engagement . "\n\n";
    $email_body .= "Message:\n" . $message . "\n";
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $name . ' <' . $email . '>',
        'Reply-To: ' . $email
    );
    
    // Send email
    $sent = wp_mail($to, $subject, $email_body, $headers);
    
    if ($sent) {
        wp_send_json_success('Message sent successfully');
    } else {
        wp_send_json_error('Failed to send message');
    }
}
