    <?php

/**
 * @author Sagar Pathapelli
 * @class 
 */
class NetworkAdminCommand extends CConsoleCommand {
    
    /**
     * @author Sagar
     * @return 
     */
    public function actionIndex($stream,$date){
        try{
            
        } catch (Exception $ex) {
            Yii::log("NetworkAdminCommand:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in NetworkAdminCommand->actionIndex==".$ex->getMessage());
        }
    }
    
    public function actionAutoFollowAdmin() {
        try {
            $netwokAdminObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType( YII::app()->params['NetworkAdminEmail'], 'Email');
            $userId = (int)($netwokAdminObj->UserId);
            $users = ServiceFactory::getSkiptaUserServiceInstance()->getAllUserExceptNetworkAdminService($userId);  
            $i=0;
            if (!is_string($users)) {
                foreach ($users as $user) {
                    $result = ServiceFactory::getSkiptaUserServiceInstance()->followAUser($user->UserId, $userId);
                    $i++;
                }
            }
        } catch (Exception  $ex) {
            echo  $ex->getTraceAsString();
            Yii::log("NetworkAdminCommand:actionAutoFollowAdmin::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
}
