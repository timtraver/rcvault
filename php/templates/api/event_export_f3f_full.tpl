"{$event->info.event_id}"{$fs}"{$event->info.event_name}"{$fs}"{$event->info.location_name}"{$fs}"{$event->info.event_start_date|date_format:"m/d/y"}"{$fs}"{$event->info.event_end_date|date_format:"m/d/y"}"{$fs}"{$event->info.event_type_name}"{$fs}"{$total_rounds}"
"Pilot_id"{$fs}"Pilot_Bib"{$fs}"First_Name"{$fs}"Last_Name"{$fs}"Pilot_Class"{$fs}"AMA"{$fs}"FAI"{$fs}"Team_Name"
"group"{$fs}"order"{$fs}"seconds"{$fs}"penalty"
{foreach $event->pilots as $event_pilot_id =>$p}"{$p.pilot_id}"{$fs}"{$p.event_pilot_bib}"{$fs}"{$p.pilot_first_name}"{$fs}"{$p.pilot_last_name}"{$fs}"{$p.class_description}"{$fs}"{$p.pilot_ama}"{$fs}"{$p.pilot_fai}"{$fs}"{$p.event_pilot_team}"
{foreach $rounds as $evid => $round}{if $evid == $event_pilot_id}{foreach $round as $round_number => $r}"{$r.event_pilot_round_flight_group}"{$fs}"{$r.event_pilot_round_flight_order}"{$fs}"{$r.event_pilot_round_flight_seconds}"{$fs}"{$r.event_pilot_round_flight_penalty}"
{/foreach}{/if}{/foreach}{/foreach}