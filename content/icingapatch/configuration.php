<?php
/* Icinga Web 2 | (c) 2014 Icinga Development Team | GPLv2+ */

/** @var $this \Icinga\Application\Modules\Module */

$this->providePermission(
    'monitoring/command/*',
    $this->translate('Allow all commands')
);
$this->providePermission(
    'monitoring/command/schedule-check',
    $this->translate('Allow scheduling host and service checks')
);
$this->providePermission(
    'monitoring/command/acknowledge-problem',
    $this->translate('Allow acknowledging host and service problems')
);
$this->providePermission(
    'monitoring/command/remove-acknowledgement',
    $this->translate('Allow removing problem acknowledgements')
);
$this->providePermission(
    'monitoring/command/comment/*',
    $this->translate('Allow adding and deleting host and service comments')
);
$this->providePermission(
    'monitoring/command/comment/add',
    $this->translate('Allow commenting on hosts and services')
);
$this->providePermission(
    'monitoring/command/comment/delete',
    $this->translate('Allow deleting host and service comments')
);
$this->providePermission(
    'monitoring/command/downtime/*',
    $this->translate('Allow scheduling and deleting host and service downtimes')
);
$this->providePermission(
    'monitoring/command/downtime/schedule',
    $this->translate('Allow scheduling host and service downtimes')
);
$this->providePermission(
    'monitoring/command/downtime/delete',
    $this->translate('Allow deleting host and service downtimes')
);
$this->providePermission(
    'monitoring/command/process-check-result',
    $this->translate('Allow processing host and service check results')
);
$this->providePermission(
    'monitoring/command/feature/instance',
    $this->translate('Allow processing commands for toggling features on an instance-wide basis')
);
$this->providePermission(
    'monitoring/command/feature/object/*',
    $this->translate('Allow processing commands for toggling features on host and service objects')
);
$this->providePermission(
    'monitoring/command/feature/object/active-checks',
    $this->translate('Allow processing commands for toggling active checks on host and service objects')
);
$this->providePermission(
    'monitoring/command/feature/object/passive-checks',
    $this->translate('Allow processing commands for toggling passive checks on host and service objects')
);
$this->providePermission(
    'monitoring/command/feature/object/notifications',
    $this->translate('Allow processing commands for toggling notifications on host and service objects')
);
$this->providePermission(
    'monitoring/command/feature/object/event-handler',
    $this->translate('Allow processing commands for toggling event handlers on host and service objects')
);
$this->providePermission(
    'monitoring/command/feature/object/flap-detection',
    $this->translate('Allow processing commands for toggling flap detection on host and service objects')
);
$this->providePermission(
    'monitoring/command/send-custom-notification',
    $this->translate('Allow sending custom notifications for hosts and services')
);

$this->provideRestriction(
    'monitoring/filter/objects',
    $this->translate('Restrict views to the Icinga objects that match the filter')
);
$this->provideRestriction(
    'monitoring/blacklist/properties',
    $this->translate('Hide the properties of monitored objects that match the filter')
);

$this->provideConfigTab('backends', array(
    'title' => $this->translate('Configure how to retrieve monitoring information'),
    'label' => $this->translate('Backends'),
    'url' => 'config'
));
$this->provideConfigTab('security', array(
    'title' => $this->translate('Configure how to protect your monitoring environment against prying eyes'),
    'label' => $this->translate('Security'),
    'url' => 'config/security'
));
$this->provideSetupWizard('Icinga\Module\Monitoring\MonitoringWizard');

/*
 * Available Search Urls
 */
$this->provideSearchUrl($this->translate('Hosts'), 'monitoring/list/hosts?sort=host_severity&limit=10', 99);
$this->provideSearchUrl($this->translate('Services'), 'monitoring/list/services?sort=service_severity&limit=10', 98);
$this->provideSearchUrl($this->translate('Hostgroups'), 'monitoring/list/hostgroups?limit=10', 97);
$this->provideSearchUrl($this->translate('Servicegroups'), 'monitoring/list/servicegroups?limit=10', 96);

/*
 * Available navigation items
 */
$this->provideNavigationItem('host-action', $this->translate('Host Action'));
$this->provideNavigationItem('service-action', $this->translate('Service Action'));
// Notes are disabled as we're not sure whether to really make a difference between actions and notes
//$this->provideNavigationItem('host-note', $this->translate('Host Note'));
//$this->provideNavigationItem('service-note', $this->translate('Service Note'));

/*
 * Problems Section
 */
$section = $this->menuSection(N_('Problems'), array(
    'renderer' => array(
        'SummaryNavigationItemRenderer',
        'state' => 'critical'
    ),
    'icon'      => 'block',
    'priority'  => 20
));
$section->add(N_('Host Problems'), array(
    'renderer'  => array(
        'MonitoringBadgeNavigationItemRenderer',
        'columns' => array(
            'hosts_down_unhandled' => $this->translate('%d unhandled hosts down')
        ),
        'state'    => 'critical',
        'dataView' => 'statussummary'
    ),
    'url'       => 'monitoring/list/hosts?host_problem=1&sort=host_severity',
    'priority'  => 50
));
$section->add(N_('Service Problems'), array(
    'renderer'  => array(
        'MonitoringBadgeNavigationItemRenderer',
        'columns' => array(
            'services_critical_unhandled' => $this->translate('%d unhandled services critical')
        ),
        'state'    => 'critical',
        'dataView' => 'statussummary'
    ),
    'url'       => 'monitoring/list/services?service_problem=1&sort=service_severity&dir=desc',
    'priority'  => 60
));
$section->add(N_('Service Grid'), array(
    'url'       => 'monitoring/list/servicegrid?problems',
    'priority'  => 70
));
$section->add(N_('Current Downtimes'), array(
    'url'       => 'monitoring/list/downtimes?downtime_is_in_effect=1',
    'priority'  => 80
));

/*
 * Overview Section
 */
$section = $this->menuSection(N_('Overview'), array(
    'icon'      => 'sitemap',
    'priority'  => 30
));
$section->add(N_('Tactical Overview'), array(
    'url'      => 'monitoring/tactical',
    'priority' => 40
));
$section->add(N_('Hosts'), array(
    'url'      => 'monitoring/list/hosts',
    'priority' => 50
));
$section->add(N_('Services'), array(
    'url'      => 'monitoring/list/services',
    'priority' => 50
));
$section->add(N_('Servicegroups'), array(
    'url'      => 'monitoring/list/servicegroups',
    'priority' => 60
));
$section->add(N_('Hostgroups'), array(
    'url'      => 'monitoring/list/hostgroups',
    'priority' => 60
));
$section->add(N_('Contacts'), array(
    'url'      => 'monitoring/list/contacts',
    'priority' => 70
));
$section->add(N_('Contactgroups'), array(
    'url'      => 'monitoring/list/contactgroups',
    'priority' => 70
));
$section->add(N_('Comments'), array(
    'url'      => 'monitoring/list/comments?comment_type=(comment|ack)',
    'priority' => 80
));
$section->add(N_('Downtimes'), array(
    'url'      => 'monitoring/list/downtimes',
    'priority' => 80
));

/*
 * History Section
 */
$section = $this->menuSection(N_('History'), array(
    'icon'      => 'rewind',
    'priority'  => 90
));
$section->add(N_('Event Grid'), array(
    'priority'  => 10,
    'url'       => 'monitoring/list/eventgrid'
));
$section->add(N_('Event Overview'), array(
    'priority'  => 20,
    'url'       => 'monitoring/list/eventhistory?timestamp>=-7%20days'
));
$section->add(N_('Notifications'), array(
    'priority'  => 30,
    'url'       => 'monitoring/list/notifications?notification_timestamp>=-7%20days',
));
$section->add(N_('Timeline'), array(
    'priority'  => 40,
    'url'       => 'monitoring/timeline'
));

/*
 * Reporting Section
 */
$section = $this->menuSection(N_('Reporting'), array(
    'icon'      => 'barchart',
    'priority'  => 100
));

$section->add(N_('Alert Summary'), array(
   'url'    => 'monitoring/alertsummary/index'
));

/*
 * System Section
 */
$section = $this->menuSection(N_('System'));
$section->add(N_('Monitoring Health'), array(
    'url'      => 'monitoring/health/info',
    'priority' => 720,
    'renderer' => 'BackendAvailabilityNavigationItemRenderer'
));
/*
 * TACTICAL OVERVIEW
 */
$dashboard = $this->dashboard(N_('TACTICAL OVERVIEW'), array('priority' => 50));
$dashboard->add(
    N_('DASHBOARD'),
    'monitoring/tactical'
);
$dashboard->add(
    N_('TIMELINE'),
    'monitoring/timeline'
);
/*
 * SITE HEALTH
 */
$dashboard = $this->dashboard(N_('SITE HEALTH'), array('priority' => 50));
$dashboard->add(
    N_('HOSTS'),
    'monitoring/list/servicegrid?(service_display_name=*ping4*|service_display_name=*Memory*|service_display_name=*Disk*|service_display_name=*CPU*|service_display_name=NTP)&service_state=2&modifyFilter=1'
);
$dashboard->add(
    N_('DATABASE'),
    'monitoring/list/services?service=*sql*|service_display_name=*DbServer*&modifyFilter=1&sort=service_severity&dir=desc'
);
$dashboard->add(
    N_('DALET SERVICE'),
    'monitoring/list/services?servicegroup_name=%5BAgent%20Type%5D%20Dalet%20Services%20Group&sort=service_severity&dir=desc'
);
$dashboard->add(
    N_('NAME SERVERS'),
    'monitoring/list/services?servicegroup_name=%5BAgent%20Type%5D%20Name%20Services%20Group'
);
$dashboard->add(
    N_('CORE'),
    'monitoring/list/services?service_display_name=*JobsBroker*|service_display_name=*Heavy*|service_display_name=*MediaMigration*|service_display_name=*WebSpace*|service_display_name=*Notifier*|service_display_name=*DaletPlus*&sort=host_name&dir=asc&modifyFilter=1'
);
$dashboard->add(
    N_('NOTIFIERS'),
    'monitoring/list/services?servicegroup_name=[Agent%20Type]%20NotifierServer&service_state!=OK&modifyFilter=1'
);

/*
 * SITE HEALTH
 */
$dashboard = $this->dashboard(N_('MEDIA JOBS'), array('priority' => 50));
$dashboard->add(
    N_('CORE'),
    'monitoring/list/services?service_display_name=*Broker*|service_display_name=*MediaMigration*&sort=service_severity&dir=desc&modifyFilter=1'
);
$dashboard->add(
    N_('FILE TRANSFER AGENTS'),
    'monitoring/list/services?servicegroup_name=[Agent%20Type]%20FileTransferAgent&modifyFilter=1&sort=service_severity&dir=desc'
);
$dashboard->add(
    N_('TRANSCODERS'),
    'monitoring/list/services?servicegroup_name=[Agent%20Type]%20MediaTranscoderAgent&modifyFilter=1&sort=service_severity&dir=desc'
);

/*
 * STORAGE
 */
$dashboard = $this->dashboard(N_('STORAGE'), array('priority' => 50));
$dashboard->add(
    N_('VALID LOCAL STORAGES'),
    'monitoring/list/services?servicegroup_name=[Local%20Storage%20Unit]%20Local%20Storage%20Units&service_state=ok&modifyFilter=1&sort=service_display_name&dir=asc'
);
$dashboard->add(
    N_('INVALID LOCAL STORAGE'),
    'monitoring/list/services?servicegroup_name=[Local%20Storage%20Unit]%20Local%20Storage%20Units&service_state!=ok&modifyFilter=1&limit=500&sort=service_display_name&dir=asc'
);
$dashboard->add(
    N_('VALID REMOTE STORAGES'),
    'monitoring/list/services?service_state=0&servicegroup_name=%5BRemote%20Storage%20Unit%5D%20Remote%20Storage%20Units&sort=service_severity'
);
$dashboard->add(
    N_('INVALID REMOTE STORAGES'),
    'monitoring/list/services?service_state=2&service_acknowledged=0&service_in_downtime=0&host_problem=0&servicegroup_name=%5BRemote%20Storage%20Unit%5D%20Remote%20Storage%20Units&sort=service_severity'
);
/*
 * PLAYOUT
 */
$dashboard = $this->dashboard(N_('PLAYOUT'), array('priority' => 50));
$dashboard->add(
    N_('BROADCAST SERVERS'),
    'monitoring/list/services?servicegroup_name=[Local%20Storage%20Unit]%20Local%20Storage%20Units&service_state=ok&modifyFilter=1&sort=service_display_name&dir=asc'
);
$dashboard->add(
    N_('INVALID LOCAL STORAGE'),
    'monitoring/list/services?servicegroup_name%20=%20[Agent%20Type]%20BroadcastServer&modifyFilter=1'
);
$dashboard->add(
    N_('VALID REMOTE STORAGES'),
    'monitoring/list/services?service_state=0&servicegroup_name=%5BRemote%20Storage%20Unit%5D%20Remote%20Storage%20Units&sort=service_severity'
);
$dashboard->add(
    N_('PLAYOUT AGENTS'),
    'monitoring/list/services?servicegroup_name=*Playout%20Studio*&service_display_name!=*Broadcast*&modifyFilter=1'
);
$dashboard->add(
    N_('STUDIOS'),
    'monitoring/list/servicegroups?servicegroup=*[Playout%20Studio]*&limit=500&sort=services_severity&dir=desc'
);
/*
 * INGEST
 */
$dashboard = $this->dashboard(N_('INGEST'), array('priority' => 50));
$dashboard->add(
    N_('INGEST SERVERS'),
    'monitoring/list/services?servicegroup_name=%5BAgent%20Type%5D%20IngestServer'
);
$dashboard->add(
    N_('RECORDING AGENTS'),
    'monitoring/list/services?servicegroup_name!=*Studio*&servicegroup_name=*Recorder*&modifyFilter=1'
);
/*
 * Current Incidents
 */
//$dashboard = $this->dashboard(N_('Current Incidents'), array('priority' => 50));
//$dashboard->add(
//    N_('Service Problems'),
//    'monitoring/list/services?service_problem=1&limit=10&sort=service_severity'
//);
//$dashboard->add(
//    N_('Recently Recovered Services'),
//    'monitoring/list/services?service_state=0&limit=10&sort=service_last_state_change&dir=desc'
//);
//$dashboard->add(
//    N_('Host Problems'),
//    'monitoring/list/hosts?host_problem=1&sort=host_severity'
//);

/*
 * Overview
 */
//$dashboard = $this->dashboard(N_('Overview'), array('priority' => 60));
//$dashboard->add(
//    N_('Service Grid'),
//    'monitoring/list/servicegrid?limit=15,18'
//);
//$dashboard->add(
//    N_('Service Groups'),
//    'monitoring/list/servicegroups'
//);
//$dashboard->add(
//    N_('Host Groups'),
//    'monitoring/list/hostgroups'
//);

/*
 * Most Overdue
 */
//$dashboard = $this->dashboard(N_('Overdue'), array('priority' => 70));
//$dashboard->add(
//    N_('Late Host Check Results'),
 //   'monitoring/list/hosts?host_next_update<now'
//);
//$dashboard->add(
 //   N_('Late Service Check Results'),
    'monitoring/list/services?service_next_update<now'
//);
//$dashboard->add(
//    N_('Acknowledgements Active For At Least Three Days'),
//    'monitoring/list/comments?comment_type=Ack&comment_timestamp<-3 days&sort=comment_timestamp&dir=asc'
//);
//$dashboard->add(
//    N_('Downtimes Active For More Than Three Days'),
//    'monitoring/list/downtimes?downtime_is_in_effect=1&downtime_scheduled_start<-3%20days&sort=downtime_start&dir=asc'
//);

/*
 * Muted Objects
 */
$dashboard = $this->dashboard(N_('Muted'), array('priority' => 80));
$dashboard->add(
    N_('Disabled Service Notifications'),
    'monitoring/list/services?service_notifications_enabled=0&limit=10'
);
$dashboard->add(
    N_('Disabled Host Notifications'),
    'monitoring/list/hosts?host_notifications_enabled=0&limit=10'
);
$dashboard->add(
    N_('Disabled Service Checks'),
    'monitoring/list/services?service_active_checks_enabled=0&limit=10'
);
$dashboard->add(
    N_('Disabled Host Checks'),
    'monitoring/list/hosts?host_active_checks_enabled=0&limit=10'
);
$dashboard->add(
    N_('Acknowledged Problem Services'),
    'monitoring/list/services?service_acknowledgement_type=2&service_problem=1&sort=service_state&limit=10'
);
$dashboard->add(
    N_('Acknowledged Problem Hosts'),
    'monitoring/list/hosts?host_acknowledgement_type=2&host_problem=1&sort=host_severity&limit=10'
);

/*
 * Activity Stream
 */
//$dashboard = $this->dashboard(N_('Activity Stream'), array('priority' => 90));
//$dashboard->add(
//    N_('Recent Events'),
//    'monitoring/list/eventhistory?timestamp>=-3%20days&sort=timestamp&dir=desc&limit=8'
//);
//$dashboard->add(
//    N_('Recent Hard State Changes'),
//    'monitoring/list/eventhistory?timestamp>=-3%20days&type=hard_state&sort=timestamp&dir=desc&limit=8'
//);
//$dashboard->add(
//    N_('Recent Notifications'),
//    'monitoring/list/eventhistory?timestamp>=-3%20days&type=notify&sort=timestamp&dir=desc&limit=8'
//);
//$dashboard->add(
//    N_('Downtimes Recently Started'),
//    'monitoring/list/eventhistory?timestamp>=-3%20days&type=dt_start&sort=timestamp&dir=desc&limit=8'
//);
//$dashboard->add(
//    N_('Downtimes Recently Ended'),
//    'monitoring/list/eventhistory?timestamp>=-3%20days&type=dt_end&sort=timestamp&dir=desc&limit=8'
//);

/*
 * Stats
 */
//$dashboard = $this->dashboard(N_('Stats'), array('priority' => 99));
//$dashboard->add(
//    N_('Check Stats'),
//    'monitoring/health/stats'
//);
//$dashboard->add(
//    N_('Process Information'),
//    'monitoring/health/info'
//);

/*
 * CSS
 */
$this->provideCssFile('service-grid.less');
$this->provideCssFile('tables.less');
