<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class api_panel extends controller{

    public $sError=null;
    public $sExError=null;

    private $showData=null;

    public function render(){
        $get=$this->getRequest('get');
        if(isset($get['fnc'])){
            $isComplete=false;
            $data=null;
            switch ($get['fnc']){
                case 'modify':
                    $isComplete=$this->api_modify();
                    break;
                case 'show':
                    $isComplete=$this->api_show();
                    break;
                case 'add':
                    $isComplete=$this->api_add();
                    break;
                case 'upload':
                    $isComplete=$this->api_upload();
                    break;
                case 'delete':
                    $isComplete=$this->api_delete();
                    break;
                case 'sync':
                    $isComplete=$this->sync();
                    break;
            }
            $response=array(
                'status'=>$isComplete,
                'data'=>$this->showData,
                //'getQuery'=>$get,
                //'postQuery'=>$this->getRequest('post')
                'error'=>$this->sExError
            );
            App::ajax(json_encode($response));
        }else{
            //$this->viewData['oSearchTemplates']=$this->attachSearchTemplates();;
            //return 'price.tpl';
        }
        App::ajax($this->sError);
    }

    public function sync(){
        $priceExtractor = App::newJump('priceExtractor','modules');
        return $priceExtractor->syncPrices();
    }

    public function api_upload(){
        $post=$this->getRequest('file');
        $oMicroUploader=App::newJump('microUploader','libs');

        if($oMicroUploader->setUploadDir(ROOT_DIR.'images/')){
            $this->showData=$oMicroUploader->upload($post['file']);
            return true;
        }

        return false;
    }

    public function api_delete(){
        $get=$this->getRequest('get');
        if(isset($get['case'])){
            switch ($get['case']){
                case 'manufacturer':
                    //$this->showData=$this->addManufacturer();
                    break;
                case 'model':
                    //$this->showData=$this->addModel();
                    break;
                case 'price':
                    //$this->showData=$this->addPrice();
                    break;
                case 'parameter':
                    $this->showData=$this->deleteParameter();
                    break;
                case 'company':
                    $this->showData=$this->deleteCompany();
                    break;
                case 'locations':
                    $this->showData=$this->deleteLocations();
                    break;
                case 'currencyRate':
                    $this->showData=$this->deleteCurrencyRate();
                    break;
                case 'settings':
                    //$this->showData=$this->addSettings();
                    break;
                case 'synonym':
                    $this->showData=$this->deleteSynonym();
                    break;
            }
            return true;
        }
        return false;
    }

    private function deleteSynonym(){
        $post = $this->getRequest('post');
        $ids = json_decode($post['ids'],true);
        if(!empty($ids)){
            $queriesArray = array();
            $total = sizeof($ids);
            for($i=0; $i<$total; $i++){
                if($ids[$i]['type']==41){
                    $queriesArray[]='DELETE FROM wheel_synonym2model
                    WHERE id='.$ids[$i]['id'].';';
                }elseif($ids[$i]['type']==42){
                    $queriesArray[]='DELETE FROM wheel_synonym2manufacturers
                    WHERE id='.$ids[$i]['id'].';';
                }else{
                    $queriesArray[]='DELETE FROM wheel_synonym2dict
                    WHERE id='.$ids[$i]['id'].';';
                }
            }
            if(!empty($queriesArray)){
                $dbo=App::DBO();
                $query=implode(' ',$queriesArray);
                $stmt = $dbo->prepare($query);
                return $stmt->execute();
            }
            return false;
        }
    }

    private function deleteCompany(){
        $post = $this->getRequest('post');
        $ids = $post['ids'];
        if(!empty($ids)){
            $dbo=App::DBO();
            $query='DELETE FROM wheel_companies
                    WHERE id IN (\''.$ids.'\')';
            $stmt = $dbo->prepare($query);
            $stmt->execute();
            $queryBilling='DELETE FROM wheel_company2billing
                    WHERE companyId IN (\''.$ids.'\')';
            $stmt = $dbo->prepare($queryBilling);
            $stmt->execute();
            $queryUser='DELETE FROM wheel_user
                    WHERE companyId IN (\''.$ids.'\')';
            $stmt = $dbo->prepare($queryUser);
            $stmt->execute();
            $queryPrice='DROP TABLE wheel_price_com'.$ids;
            $stmt = $dbo->prepare($queryPrice);
            $stmt->execute();
            return (null != Price::synchronisePriceStructure());
        }
    }

    private function deleteParameter(){
        $post = $this->getRequest('post');
        $ids = json_decode($post['ids'],true);
        if(!empty($ids)){
            $idsArray = array();
            $total = sizeof($ids);
            $typeFrom = null;
            $queryTemplate = null;
            for($i=0; $i<$total; $i++){
                if(!empty($ids[$i]['type']) && !empty($ids[$i]['id'])){
                    if ($ids[$i]['type']==41){
                        $idsArray[] = $ids[$i]['id'];
                        $typeFrom = 'wheel_models';
                    }elseif ($ids[$i]['type']==42){
                        $idsArray[] = $ids[$i]['id'];
                        $typeFrom = 'wheel_manufacturers';
                    }else{
                        $idsArray[] = $ids[$i]['id'];
                        $typeFrom = 'wheel_dict2parameters';
                    }
                    if($i==$total-1){
                        $ids = implode(',',$idsArray);
                        $queryTemplate='DELETE FROM '.$typeFrom.'
                        WHERE id IN ('.$ids.')';
                    }
                }
            }
            if($queryTemplate != null){
                $dbo=App::DBO();
                $query=$queryTemplate;
                $stmt = $dbo->prepare($query);
                return $stmt->execute();
            }
        }
    }

    private function deleteCurrencyRate(){
        $post = $this->getRequest('post');
        $ids = $post['ids'];
        if(!empty($ids)){
            $dbo=App::DBO();
            $query='DELETE FROM wheel_currencyRate
                    WHERE iso=\''.$ids.'\'';
            $stmt = $dbo->prepare($query);
            return $stmt->execute();
        }
    }

    private function deleteLocations(){
        $post = $this->getRequest('post');
        $ids = $post['ids'];
        if(!empty($ids)){
            $dbo=App::DBO();
            $query='DELETE FROM wheel_city
                    WHERE id IN ('.$ids.')';
            $stmt = $dbo->prepare($query);
            return $stmt->execute();
        }
    }

    public function api_add(){
        $post=$this->getRequest('post');
        if(isset($post['fnc'])){
            switch ($post['fnc']){
                case 'manufacturer':
                    $this->showData=$this->addManufacturer();
                    break;
                case 'model':
                    $this->showData=$this->addModel();
                    break;
                case 'price':
                    $this->showData=$this->addPrice();
                    break;
                case 'parameter':
                    $this->showData=$this->addParameter();
                    break;
                case 'company':
                    $this->showData=$this->addCompany();
                    break;
                case 'locations':
                    $this->showData=$this->addLocations();
                    break;
                case 'currencyRate':
                    $this->showData=$this->addUpdateCurrencyRate();
                    break;
                case 'settings':
                    $this->showData=$this->addSettings();
                    break;
            }
            return true;
        }
        return false;
    }

    private function addLocations(){
        $post = $this->getRequest('post');
        $locations = $post['locations'];
        if(!empty($locations['name'])){
            if(!empty($locations['id']) && !empty($locations['region_id'])){
                $dbo=App::DBO();
                $query='UPDATE wheel_city
                        SET
                        name=\''.$locations['name'].'\',
                        region_id=\''.$locations['region_id'].'\'
                        WHERE id='.$locations['id'].'';
                $stmt = $dbo->prepare($query);
                return $stmt->execute();
            }else{
                $dbo=App::DBO();
                $query='INSERT INTO wheel_city
                        (name, region_id)
                        VALUES
                        (\''.$locations['name'].'\', '.$locations['region_id'].')';
                $stmt = $dbo->prepare($query);
                $stmt->execute();

                return array(
                    'add'=>'locations'
                );
            }
        }
    }

    private function addUpdateCurrencyRate(){
        $post = $this->getRequest('post');
        $rate = $post['currencyRate'];
        if(!empty($rate['iso']) && !empty($rate['rate'])){
            $dbo=App::DBO();
            $query='INSERT INTO wheel_currencyRate (iso, rate)
                    VALUES (\''.$rate['iso'].'\','.$rate['rate'].')
                    ON DUPLICATE KEY UPDATE rate='.$rate['rate'].';';
            $stmt = $dbo->prepare($query);
            return $stmt->execute();
        }
    }

    private function addCompany(){
        $post = $this->getRequest('post');
        $company = $post['company'];
        if(!empty($company['name'])){
            if(!empty($company['id'])){
                $dbo=App::DBO();
                $query='UPDATE wheel_companies
                        SET
                        name=\''.$company['name'].'\',
                        cityId=\''.$company['city_id'].'\',
                        iso=\''.$company['iso'].'\',
                        rate=\''.$company['rate'].'\'
                        WHERE id='.$company['id'].'';
                $stmt = $dbo->prepare($query);
                return $stmt->execute();
            }else{
                $companyList = array();
                $dbo=App::DBO();
                $query='INSERT INTO wheel_companies
                        (name, cityId, active, warehouse, iso, rate, expire)
                        VALUES
                        (\''.$company['name'].'\', \''.$company['city_id'].'\', 1, 1, \''.$company['iso'].'\', \''.$company['rate'].'\', \''.date('Y-m-d H:i:s', strtotime('+2 days')).'\')';
                $stmt = $dbo->prepare($query);
                $stmt->execute();

                $id=$dbo->lastInsertId();

                $login = $post['user']['email'];
                $pass = md5(123123);

                $queryUser='INSERT INTO wheel_user
                (email, pass, firstName, lastName, phone, cityId, login, roleId, userType, balance, companyId, subscribe)
                VALUES
                (\''.$post['user']['email'].'\', \''.$pass.'\', \''.$post['user']['firstName'].'\', \''.$post['user']['lastName'].'\', \''.$post['user']['phone'].'\', \''.$company['city_id'].'\', \''.$login.'\', 1, 3, \''.$post['user']['balance'].'\', '.$id.', 1)';
                $stmt = $dbo->prepare($queryUser);
                $stmt->execute();

                $queryBilling='INSERT INTO wheel_company2billing
                (companyId, shop_name, email, phone_1, cityId, active)
                VALUES
                ('.$id.', \''.$company['name'].'\', \''.$post['user']['email'].'\', \''.$post['user']['phone'].'\', '.$company['city_id'].', 1)';
                $stmt = $dbo->prepare($queryBilling);
                $stmt->execute();

                Price::createCompanyPriceTable($id);
                /*$query='
                CREATE TABLE IF NOT EXISTS `wheel_price_com'.$id.'` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `price_1` float NOT NULL,
                  `price_2` float DEFAULT NULL,
                  `price_3` float DEFAULT NULL,
                  `price_4` float DEFAULT NULL,
                  `stock_1` int(5) NOT NULL,
                  `stock_2` int(5) DEFAULT NULL,
                  `stock_3` int(5) DEFAULT NULL,
                  `manufacturer_id` int(11) NOT NULL,
                  `model_id` int(11) NOT NULL,
                  `artnum` varchar(32) DEFAULT NULL,
                  `img` varchar(255) DEFAULT NULL,
                  `company_id` int(11) NOT NULL,
                  `date` int(11) NOT NULL,
                  `size_r` float DEFAULT NULL,
                  `size_w` float DEFAULT NULL,
                  `size_h` float DEFAULT NULL,
                  `size_i` varchar(4) DEFAULT NULL,
                  `si_f` varchar(4) DEFAULT NULL,
                  `si_b` varchar(4) DEFAULT NULL,
                  `sw_f` varchar(4) DEFAULT NULL,
                  `sw_b` varchar(4) DEFAULT NULL,
                  `spike` int(4) DEFAULT NULL,
                  `color` int(4) DEFAULT NULL,
                  `technology` int(4) DEFAULT NULL,
                  `marking` int(4) DEFAULT NULL,
                  `et` float DEFAULT NULL,
                  `dia` float DEFAULT NULL,
                  `pcd_1` int(3) NOT NULL,
                  `pcd_2` int(3) NOT NULL,
                  `bolt` int(3) NOT NULL,
                  `manufactured_country` int(3) DEFAULT NULL,
                  `manufactured_year` varchar(12) DEFAULT NULL,
                  `price_line` text NOT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';

                $stmt = $dbo->prepare($query);

                if($stmt->execute()){*/
                    $this->syncView();
                    $params = $this->getModel('wheel_companies'); //Getter for datamodel classes -> we have an object of class
                    $params->setId($id);
                    $params->commit(true); //Commit - set data to storage from model - this able us to controlling models
                    $companyList = $params->datamodel;
                //}

                return array(
                    'add'=>'company',
                    'id'=>$id,
                    'company'=>$companyList
                );
            }
        }

        return false;
    }

    private function syncView()
    {
        Price::synchronisePriceStructure();
        /*$scopeTables = array();
        $dbo=App::DBO();
        $query='SHOW TABLES WHERE `Tables_in_wheels` LIKE \'wheel_price_com%\'';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $scopeTables[] = $row['Tables_in_wheels'];
        }
        if(!empty($scopeTables)){
            $unionsSql = '
                CREATE OR REPLACE VIEW wheel_priceview AS SELECT `wheel_price`.*, wheel_manufacturers.name AS manufacturer,
                wheel_models.name AS model,
                wheel_models.src,
                wheel_models.season, wheel_models.use,
                wheel_models.type_transport, wheel_models.axle,
                wheel_manufacturers2type.type as manufacturer_type,
                wheel_manufacturers2type.wheel_type as manufacturer_wheel_type
                FROM `wheel_price`
                LEFT JOIN wheel_manufacturers
                ON wheel_manufacturers.id=manufacturer_id
                LEFT JOIN wheel_manufacturers2type ON wheel_manufacturers.id=wheel_manufacturers2type.manufacturer_id
                LEFT JOIN wheel_models ON wheel_models.id=model_id';
            foreach ($scopeTables as $table){
                $unionsSql .= ' UNION SELECT `'.$table.'`.*, wheel_manufacturers.name AS manufacturer,
                    wheel_models.name AS model,
                    wheel_models.src,
                    wheel_models.season, wheel_models.use,
                    wheel_models.type_transport, wheel_models.axle,
                    wheel_manufacturers2type.type as manufacturer_type,
                    wheel_manufacturers2type.wheel_type as manufacturer_wheel_type
                    FROM `'.$table.'`
                    LEFT JOIN wheel_manufacturers
                    ON wheel_manufacturers.id=manufacturer_id
                    LEFT JOIN wheel_manufacturers2type ON wheel_manufacturers.id=wheel_manufacturers2type.manufacturer_id
                    LEFT JOIN wheel_models ON wheel_models.id=model_id';
            }
            $stmt = $dbo->prepare($unionsSql);
            $stmt->execute();
        }*/
    }

    private function addSettings(){
        $post = $this->getRequest('post');
        if($post['price_name']!=null && $post['company_id']!=null && $post['settings']!=null){
            $dbo=App::DBO();
            $query='INSERT INTO wheel_settings2company
                    (company_id, price_name, settings)
                    VALUES
                    ('.$post['company_id'].', \''.str_replace("'", "\'", $post['price_name']).'\', \''.json_encode($post['settings']).'\')
                    ON DUPLICATE KEY UPDATE price_name=\''.str_replace("'", "\'", $post['price_name']).'\', settings=\''.json_encode($post['settings']).'\';';
            $stmt = $dbo->prepare($query);
            $stmt->execute();

            return true;
        }
        return false;
    }

    private function addParameter(){
        $post = $this->getRequest('post');
        if(isset($post['type'])){
            if ($post['type']==41) {
                return $this->addUpdateModelAdvanced();
            } elseif ($post['type']==42) {
                return $this->addUpdateManufacturer();
            } else {
                return $this->addUpdateParameter();
            }
        }
        return true;
    }

    private function addPrice(){
        $post = $this->getRequest('post');
        if(isset($post['priceData'])){
            $decoded = json_decode($post['priceData']);
            if($decoded){
                $priceExtractor = App::newJump('priceExtractor','modules');
                return $priceExtractor->DBOExtract($decoded);
            }
            return false;
        }
        return false;
    }

    private function addUpdateParameter(){
        $post=$this->getRequest('post');
        $dict=$post['dict'];
        $type=$post['type'];
        $status=false;
        if(!empty($dict['parameter_id']) && !empty($dict['name'])){
            $dbo=App::DBO();
            $query='UPDATE wheel_dict2parameters
                    SET
                    name=\''.str_replace("'", "\'", $dict['name']).'\'
                    WHERE id='.$dict['parameter_id'];
            $stmt = $dbo->prepare($query);
            $status=$stmt->execute();
        }elseif(!empty($dict['name'])){
            $dbo=App::DBO();
            $query='INSERT INTO wheel_dict2parameters
                    (parameter_id, name)
                    VALUES
                    ('.$type.',\''.str_replace("'", "\'", $dict['name']).'\')';
            $stmt = $dbo->prepare($query);
            $status=$stmt->execute();
        }
        return array(
            'status'=>$status
        );
    }

    private function addUpdateManufacturer(){
        $post=$this->getRequest('post');
        $manufacturer=$post['manufacturer'];
        $dict=$post['dict'];
        $status=false;
        if($dict['parameter_id']==null){
            $dbo=App::DBO();
            $r = null;
            $isExistRecord = $this->isExistRecord(
                'wheel_manufacturers',
                array(
                    'name'=>array(
                        'type' => 'string',
                        'value' => str_replace("'", "\'",$dict['name'])
                    )
                ),$r,true);
            if ( !$isExistRecord ) {
                $query='INSERT INTO wheel_manufacturers
                        (name)
                        VALUES
                        (\''.str_replace("'", "\'", $dict['name']).'\')';
                $stmt = $dbo->prepare($query);
                if($stmt->execute()){
                    $id=$dbo->lastInsertId();
                    $query='INSERT INTO wheel_manufacturers2type
                        (`manufacturer_id`,`type`, `wheel_type`)
                        VALUES
                        ('.$id.','.$manufacturer['type'].','.((empty($manufacturer['wheel_type']))?'NULL':$manufacturer['wheel_type']).')';
                    $stmt = $dbo->prepare($query);
                    $status=$stmt->execute();
                }
            }
        }else{
            $dbo=App::DBO();
            $query='UPDATE wheel_manufacturers
                    SET
                    name=\''.str_replace("'", "\'", $dict['name']).'\'
                    WHERE id='.$dict['parameter_id'];
            $stmt = $dbo->prepare($query);
            if($stmt->execute()){
                $query='UPDATE wheel_manufacturers2type
                    SET
                    `type`='.$manufacturer['type'].',
                    `wheel_type`='.((empty($manufacturer['wheel_type']))?'NULL':$manufacturer['wheel_type']).'
                    WHERE `manufacturer_id`='.$dict['parameter_id'];
                $stmt = $dbo->prepare($query);
                $status=$stmt->execute();
            }
        }
        return array(
            'status'=>$status
        );
    }

    private function addManufacturer(){
        $post=$this->getRequest('post');
        $synonym=$post['synonym'];
        $manufacturer=$post['manufacturer'];
        if(!empty($manufacturer['name']) && $manufacturer['type']!=null){
            $dbo=App::DBO();
            $query='INSERT INTO wheel_manufacturers
                    (name)
                    VALUES
                    (\''.str_replace("'", "\'", $manufacturer['name']).'\')';
            $stmt = $dbo->prepare($query);
            $stmt->execute();

            $id=$dbo->lastInsertId();

            $dbo=App::DBO();
            $query='INSERT INTO wheel_manufacturers2type
                    (manufacturer_id,type)
                    VALUES
                    ('.$id.','.$manufacturer['type'].')';
            $stmt = $dbo->prepare($query);
            $stmt->execute();
            return array(
                'add'=>'model',
                'id'=>$id,
                'manufacturer'=>$this->getManufacturerById($id),
                'list'=>$this->attachManufacturers()
            );
        }elseif(!empty($synonym['synonym']) && $synonym['manufacturer_id']!=null){
            $synonymExistence = $this->_checkManufacturerSynonym($synonym['synonym']);
            if($synonymExistence!=null){
                $id = $synonymExistence;
            }else{
                $dbo=App::DBO();
                $query='INSERT INTO wheel_synonym2manufacturers
                        (manufacturer_id,synonym)
                        VALUES
                        ('.$synonym['manufacturer_id'].',\''.str_replace("'", "\'", $synonym['synonym']).'\')';
                $stmt = $dbo->prepare($query);
                $stmt->execute();
                $id=$dbo->lastInsertId();
            }
            return array(
                'add'=>'model',
                'id'=>$id,
                'manufacturer'=>$this->getManufacturerById($synonym['manufacturer_id']),
                'list'=>$this->attachManufacturers()
            );
        }
        return false;
    }

    private function _checkManufacturerSynonym($synonym){
        $isExist = null;
        $dbo=App::DBO();
        $query='SELECT wheel_synonym2manufacturers.id
                FROM wheel_synonym2manufacturers
                WHERE wheel_synonym2manufacturers.synonym=\''.str_replace("'", "\'", $synonym).'\'';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $isExist = $row['id'];
        }
        return $isExist;
    }

    private function addManufacturerSynonym($id){
        $post=$this->getRequest('post');
        $synonym=$post['synonym'];
        if($this->_checkManufacturerSynonym($synonym['synonym']) == null){
            $dbo=App::DBO();
            $query='INSERT INTO wheel_synonym2manufacturers
                        (manufacturer_id,synonym)
                        VALUES
                        ('.$id.',\''.str_replace("'", "\'", $synonym['synonym']).'\')';
            $stmt = $dbo->prepare($query);
            $stmt->execute();
        }
        return true;
    }

    public function attachRawManufacturers(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT * FROM wheel_manufacturers
                INNER JOIN wheel_manufacturers2type
                WHERE wheel_manufacturers.id=wheel_manufacturers2type.manufacturer_id
                GROUP BY wheel_manufacturers.id';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $viewData[]=$row;
        }//"->datamodel" - pseudo storage. After commit this is not empty)
        return $viewData;
    }

    public function attachManufacturers(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT * FROM wheel_manufacturers
                ORDER BY wheel_manufacturers.name';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $viewData[]=$row;
        }//"->datamodel" - pseudo storage. After commit this is not empty)
        return $viewData;
    }

    private function addUpdateModelAdvanced(){
        $post=$this->getRequest('post');
        $model=$post['model'];
        $dict=$post['dict'];
        $status=false;
        $season = (isset($model['season']))?$model['season']:0;
        $use = (isset($model['use']))?$model['use']:0;
        $typeTransport = (isset($model['type_transport']))?$model['type_transport']:0;
        $axle = (isset($model['axle']))?$model['axle']:0;
        if($dict['manufacturer_id']!=null && $dict['name']!=null && $dict['parameter_id']==null){
            $dbo=App::DBO();
            $t = null;
            $isExistRecord = $this->isExistRecord(
                'wheel_models',
                array(
                    'name'=>array(
                        'type' => 'string',
                        'value' => str_replace("'", "\'",$dict['name'])
                    ),
                    'manufacturer_id'=>array(
                        'type' => 'string',
                        'value' => $dict['manufacturer_id']
                    )
                ),
                $t,true);
            if ( !$isExistRecord ) {
                $query='INSERT INTO wheel_models
                        (`manufacturer_id`,`name`,`description`,`season`,`use`,`type_transport`,`axle`,`src`)
                        VALUES
                        ('.$dict['manufacturer_id'].',\''.str_replace("'", "\'", $dict['name']).'\',\''.str_replace("'", "\'", $model['description']).'\',
                        '.$season.','.$use.','.$typeTransport.','.$axle.',
                        \''.$model['src'].'\')';
                $stmt = $dbo->prepare($query);
                $status=$stmt->execute();
            }
        }elseif($dict['manufacturer_id']!=null && $dict['name']!=null && $dict['parameter_id']!=null){
            $dbo=App::DBO();
            $query='UPDATE wheel_models
                    SET
                    `manufacturer_id`='.$dict['manufacturer_id'].',`name`=\''.str_replace("'", "\'",$dict['name']).'\',
                    `description`=\''.str_replace("'", "\'", $model['description']).'\',`season`='.$season.',`use`='.$use.',
                    `type_transport`='.$typeTransport.',`axle`='.$axle.',`src`=\''.$model['src'].'\'
                    WHERE `id`='.$dict['parameter_id'];
            $stmt = $dbo->prepare($query);
            $status=$stmt->execute();
        }
        return array(
            'status'=>$status
        );
    }

    private function isExistRecord($table, $rules = array(), &$record = null, $isHandleError = false)
    {
        $isExist = false;
        $where = array();
        $column = '';

        $table = '`'.$table.'`';
        foreach ($rules as $coll => $rule) {
            switch ($rule['type']) {
                case 'string':
                    if ( is_array($rule['value']) ) {
                        $rule['value'] = 'IN (\''.implode('\', \'', $rule['value']).'\')';
                    } else {
                        $rule['value'] = 'IN (\''.$rule['value'].'\')';
                    }
                    break;
                case 'int':
                    if ( is_array($rule['value']) ) {
                        $rule['value'] = 'IN ('.implode(', ', $rule['value']).')';
                    } else {
                        $rule['value'] = 'IN ('.$rule['value'].')';
                    }
                    break;
            }
            $coll = '`'.$coll.'`';
            $where[] = $coll.' '.$rule['value'];
        }

        $column = $table.'.*';

        $where = implode(' AND ', $where);

        $dbo=App::DBO();
        $query = 'SELECT COUNT(*) as counter, '.$column.' FROM '.$table.' WHERE '.$where;
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $isExist = (!$result)?false:(($result->counter > 0)?true:false);
        $record = $result;
        if($isHandleError && $isExist){
            $this->sExError = 'уже существует!';
        }
        return $isExist;
    }

    private function addModel(){
        $post=$this->getRequest('post');
        $model=$post['model'];
        $id=null;
        if($model['manufacturer_id']!=null && $model['name']!=null){
            $dbo=App::DBO();

            $record = null;
            $isExistRecord = $this->isExistRecord(
                'wheel_models',
                array(
                    'manufacturer_id'=>array(
                        'type' => 'int',
                        'value' => $model['manufacturer_id']
                    ),
                    'name'=>array(
                        'type' => 'string',
                        'value' => str_replace("'", "\'",$model['name'])
                    )
                ),$record);
            if (!$isExistRecord) {
                $query='INSERT INTO wheel_models
                        (manufacturer_id,name,description)
                        VALUES
                        ('.$model['manufacturer_id'].',\''.str_replace("'", "\'", $model['name']).'\',NULL)';
                $stmt = $dbo->prepare($query);
                $stmt->execute();
                $id = $dbo->lastInsertId();
                $this->addModelSynonym($id);
            } else {
                $id = $record->id;
                $this->addModelSynonym($id);
            }
        }elseif($model['id']!=null){
            $id=$model['id'];
            $this->addModelSynonym($id);
        }
        return array(
            'add'=>'model',
            'id'=>$id,
            'model'=>$this->getModelById($id),
            'list'=>$this->attachModelsByManufacturer($model['manufacturer_id'])
        );
    }

    private function attachModelsByManufacturer($id){
        $viewData = array();
        $dbo=App::DBO();
        $query='SELECT *
                FROM wheel_models
                WHERE wheel_models.manufacturer_id='.$id.'
                ORDER BY wheel_models.name';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $viewData[]=$row;
        }//"->datamodel" - pseudo storage. After commit this is not empty)
        return $viewData;
    }

    private function getModelById($id){
        $viewData=array();
        /*$dbo=App::DBO();
        $query='SELECT wheel_models.id,
                wheel_manufacturers.name as manufacturer,
                wheel_models.manufacturer_id,
                wheel_models.name as model
                FROM wheel_manufacturers
                INNER JOIN wheel_models
                ON wheel_manufacturers.id=wheel_models.manufacturer_id
                WHERE wheel_models.id='.$id.'';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $viewData=$row;
        }//"->datamodel" - pseudo storage. After commit this is not empty)*/
        $viewData=$this->attachSemanticDataById($id);
        return $viewData;
    }

    public function attachSemanticDataById($id){
        $params=$this->getModel('wheel_semantic'); //Getter for datamodel classes -> we have an object of class
        $params->setModelId($id);
        $params->commit(); //Commit - set data to storage from model - this able us to controlling models
        return $params->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    private function addModelSynonym($id){
        $post=$this->getRequest('post');
        $synonym=$post['synonym'];
        if(!empty($synonym['synonym']) && $id!=null){
            if(!$this->_checkModelSynonym($synonym['synonym'])){
                $dbo=App::DBO();
                $query='INSERT INTO wheel_synonym2model
                        (model_id,synonym)
                        VALUES
                        ('.$id.',\''.str_replace("'", "\'", $synonym['synonym']).'\')';
                $stmt = $dbo->prepare($query);
                $stmt->execute();
            }
            return true;
        }
        return false;
    }

    private function _checkModelSynonym($synonym){
        $isExist = array();
        $dbo=App::DBO();
        $query='SELECT wheel_synonym2model.id
                FROM wheel_synonym2model
                WHERE wheel_synonym2model.synonym=\''.str_replace("'", "\'", $synonym).'\'';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $isExist = $row;
        }
        return (sizeof($isExist)>0)?true:false;
    }

    public function api_show(){
        $get=$this->getRequest('get');
        if(isset($get['case'])){
            switch ($get['case']){
                case 'synonym_list':
                    $this->showData=$this->getSynonymList();
                    break;
                case 'values_list':
                    $id=(isset($get['selected']))?$get['selected']:null;
                    $this->showData=$this->getValuesList($id);
                    break;
                case 'company_list':
                    $this->showData=$this->getCompanyList();
                    break;
                case 'locations_list':
                    $this->showData=$this->getLocationsList();
                    break;
                case 'currencyRate_list':
                    $this->showData=$this->getCurrencyRateList();
                    break;
                case 'settings':
                    $this->showData=$this->getSettings($get['price_name'],$get['company_id']);
                    break;
            }
            return true;
        }
        return false;
    }

    private function getSettings($priceName,$companyId){
        $model=$this->getModel('wheel_settings'); //Getter for datamodel classes -> we have an object of class
        $model->setCompanyId($companyId);
        $model->setPriceName($priceName);
        $model->commit(); //Commit - set data to storage from model - this able us to controlling models
        return $model->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    private function getSynonymList(){
        $params=$this->getModel('wheel_synonymlist'); //Getter for datamodel classes -> we have an object of class
        $params->commit(); //Commit - set data to storage from model - this able us to controlling models
        return $params->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    private function getValuesList($id = null){
        $params=$this->getModel('wheel_valueslist'); //Getter for datamodel classes -> we have an object of class
        $params->commit($id); //Commit - set data to storage from model - this able us to controlling models
        return $params->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    private function getLocationsList(){
        $params=$this->getModel('wheel_locations'); //Getter for datamodel classes -> we have an object of class
        $params->commit(); //Commit - set data to storage from model - this able us to controlling models
        return $params->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    private function getCurrencyRateList(){
        $params=$this->getModel('wheel_currencyRate'); //Getter for datamodel classes -> we have an object of class
        $params->commit(); //Commit - set data to storage from model - this able us to controlling models
        return $params->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    private function getCompanyList(){
        $params=$this->getModel('wheel_companies'); //Getter for datamodel classes -> we have an object of class
        $params->setWarehouse(1);
        $params->commit(true); //Commit - set data to storage from model - this able us to controlling models
        return $params->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    private function getManufacturerById($id,$isSyn=false){
        $viewData=array();
        if($id!=null){
            $dbo=App::DBO();
            if($isSyn){
            $query='SELECT wheel_manufacturers.id, wheel_manufacturers.name FROM wheel_manufacturers
                INNER JOIN wheel_synonym2manufacturers
                ON wheel_synonym2manufacturers.manufacturer_id=wheel_manufacturers.id
                WHERE wheel_synonym2manufacturers.id='.$id.'';
            }else{
            $query='SELECT wheel_manufacturers.id, wheel_manufacturers.name FROM wheel_manufacturers
                WHERE wheel_manufacturers.id='.$id.'';
            }
            $stmt = $dbo->prepare($query);
            $stmt->execute();
            while($row = $stmt->fetch(PDO::FETCH_OBJ)){
                $viewData['name']=$row->name;
                $viewData['id']=$row->id;
            }
        }
        return $viewData;
    }

    /*
     * <input type="hidden" name="fnc" value="">
        <input type="hidden" name="synonym[id]" value="">
        <input type="text" name="synonym[synonym]" placeholder="Синоним" />
        <select name="synonym[dict]">*/

    public function api_modify(){
        $post=$this->getRequest('post');
        if(isset($post['fnc'])){
            switch ($post['fnc']){
                case 'add':
                    $this->showData=$this->addSynonym();
                    break;
                case 'edit':
                    $this->showData=$this->editSynonym();
                    break;
            }
        }
    }

    private function addSynonym(){
        $post=$this->getRequest('post');

        $type=$post['type'];

        if($type==41 || $type==42){
            $status=false;
            $id=$post['synonym']['dict'];
            switch($type){
                case 41:
                    $status=$this->addModelSynonym($id);
                    break;
                case 42:
                    $status=$this->addManufacturerSynonym($id);
                    break;
            }
            return $status;
        }else{
            $field=$post['synonym'];
            if($field['synonym']!=null && $field['dict']!=null){
                $dbo=App::DBO();
                $query='INSERT INTO wheel_synonym2dict
                        (dict_id,synonym)
                        VALUES
                        ('.$field['dict'].',\''.str_replace("'", "\'", $field['synonym']).'\')';
                $stmt = $dbo->prepare($query);
                $stmt->execute();
                return $query;
            }
        }

        return false;
    }

    private function editSynonym(){
        $post=$this->getRequest('post');

        $type=$post['type'];

        if($type==41 || $type==42){
            $status=false;
            switch($type){
                case 41:
                    $status=$this->editModelSynonym();
                    break;
                case 42:
                    $status=$this->editManufacturerSynonym();
                    break;
            }
            return $status;
        }else{
            $field=$post['synonym'];
            if($field['id']!=null && $field['synonym']!=null && $field['dict']!=null){
                $dbo=App::DBO();
                $query='UPDATE wheel_synonym2dict
                        SET dict_id='.$field['dict'].' ,synonym=\''.str_replace("'", "\'", $field['synonym']).'\'
                        WHERE id='.$field['id'];
                $stmt = $dbo->prepare($query);
                $stmt->execute();
                return true;
            }
        }

        return false;
    }

    private function editModelSynonym(){
        $post=$this->getRequest('post');
        $synonym=$post['synonym'];
        if($synonym['id']!=null && !empty($synonym['synonym']) && $synonym['dict']!=null){
            $dbo=App::DBO();
            $query='UPDATE wheel_synonym2model
                    SET model_id='.$synonym['dict'].',
                    synonym=\''.str_replace("'", "\'", $synonym['synonym']).'\'
                    WHERE id='.$synonym['id'].'';
            $stmt = $dbo->prepare($query);
            $stmt->execute();
            return $query;
        }
    }

    private function editManufacturerSynonym(){
        $post=$this->getRequest('post');
        $synonym=$post['synonym'];
        if($synonym['id']!=null && !empty($synonym['synonym']) && $synonym['dict']!=null){
            $dbo=App::DBO();
            $query='UPDATE wheel_synonym2manufacturers
                    SET manufacturer_id='.$synonym['dict'].',
                    synonym=\''.str_replace("'", "\'", $synonym['synonym']).'\'
                    WHERE id='.$synonym['id'].'';
            $stmt = $dbo->prepare($query);
            $stmt->execute();
            return $query;
        }
    }
}