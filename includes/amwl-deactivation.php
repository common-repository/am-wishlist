<?php
/**
 * Deactivation 
 */
function AMWL_deactivate() {
	/**
     * Flush rewrite rules 
     */
    flush_rewrite_rules();
}
?>