<?php

class EmulateGroup {
  public static function onLoadExtensionSchemaUpdates($updater) {
    $dir = __DIR__ . '/../sql';
    $updater->addExtensionTable('EmulateGroupCurrentlyEmulating', "{$dir}/currentlyemulating.sql");
    $updater->addExtensionTable('EmulateGroupRealGroup', "{$dir}/realgroup.sql");
  }

  public static function onSidebarBeforeOutput(Skin $skin, &$bar) {
    global $wgGroupPermissions, $wgUser;

    if($wgUser->isSafeToLoad()) {
      $dbw = wfGetDB(DB_MASTER);
      $resp = $dbw->select("EmulateGroupCurrentlyEmulating", ["group_name"], ["user_id" => $wgUser->getId()]);
      if($dbw->numRows($resp) > 0) {
        $currently_emulating = $resp->next()->group_name;
        $out  = "<div style='line-height: 1.125em; font-size: 0.75em'>";
        $out .= wfMessage("emulategroup-currently", $currently_emulating);
        $out .= "<input id='emulategroupstop' style='width:130px' type='button' value='" . wfMessage("emulategroup-stop") . "'>";
        $out .= "</div>";
        $bar['Emulate'] = $out;
      } else if($wgUser->isAllowed("emulategroup")) {
        $out  = "<div style='line-height: 1.125em; font-size: 0.75em'>";
        $out .= "<select id='emulategroupgroup' autocomplete=off name='emulate-group-select' style='width:130px;text-align:center'>";
        $perms = array_keys($wgGroupPermissions);
        sort($perms);
        foreach($perms as $groupName) {
          $out .= "<option value='$groupName'>$groupName</option>";
        }
        $out .= "</select>";
        $out .= "<input id='emulategroupsubmit' style='width:130px' type='button' value='" . wfMessage("emulategroup-start") . "'>";
        $out .= "</div>";
        $bar['Emulate'] = $out;
      }
    }

    return true;
  }

  public static function onBeforePageDisplay(OutputPage $out, Skin $skin) {
    $out->addModules('ext.emulategroup.js');
  }
}
