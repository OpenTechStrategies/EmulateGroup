<?php

class EmulateGroupStop extends ApiBase {
  public function execute() {
    $user = $this->getUser();
    $dbw = wfGetDB(DB_MASTER);
    $user_id = $this->getUser()->getId();

    $current_group = $dbw->select("EmulateGroupCurrentlyEmulating", ["group_name"], ["user_id" => $user_id])->next()->group_name;
    error_log($current_group);
    $user->removeGroup($current_group);

    foreach($dbw->select("EmulateGroupRealGroup", ["group_name"], ["user_id" => $user_id]) as $row) {
      $user->addGroup($row->group_name);
    }

    $dbw->delete(
      'EmulateGroupCurrentlyEmulating',
      [ 'user_id' => $user_id ]
    );

    $dbw->delete(
      'EmulateGroupRealGroup',
      [ 'user_id' => $user_id ]
    );

    return true;
  }

  public function needsToken() {
    return 'csrf';
  }
}

?>
