<?php
/**
 * View: Month View - Calendar Event Tooltip Description
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/month/calendar-body/day/calendar-events/calendar-event/tooltip/description.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 4.9.10
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */

if ( empty( (string) $event->excerpt ) ) {
	return;
}
?>
<div class="tribe-events-calendar-month__calendar-event-tooltip-description tribe-common-b3">
	<?php //echo (string) $event->excerpt; ?>what up g
	<?php 
		$e = get_the_excerpt();
		echo do_shortcode( $d );
	 ?>
</div>
<?php if( $e ) { ?>
	<style type="text/css">
		.tribe-events-tooltip-theme {
		  width: 1200px !important;
		  max-width: unset !important;
		}
		.tribe-events-tooltip-theme .tribe-events-calendar-month__calendar-event-tooltip-featured-image-wrapper {
		  float: left;
		  margin-right: 2em;
		}
		.tribe-events-tooltip-theme .tribe-events-calendar-month__calendar-event-tooltip-title {
		  clear: none;
		}
	</style>
<?php } ?>