<?php
                // API E-GOV UNTUK HANDLE REQUEST DATA ROLE
                
                $DB_HOST        = 'localhost';
                $DB_USER        = 'mp_user';
                $DB_PASS        = 'mp_password';
                $DB_NAME        = 'mp_db';
                
                $this_user_key  = 'a7498-53a31217e594218e680dbc01590f068a';
                $this_user_pass = 'f653cc1d3e';
                
            
                if(isset($_POST['user_key']) && isset($_POST['pass_key'])){
                    extract($_POST);
                    if($user_key!=$this_user_key || $pass_key!=$this_user_pass){
                        echo json_encode([
                            'alert'     => ['class'    => 'danger', 'capt'     => '<strong>Error</strong> Api key tidak valid, silahkan coba lagi!']
                        ]);
                        exit();
                    }
                    $k = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
            
                    if($method=='get'){
                        $role = $k->query("SELECT * FROM tb_role ORDER BY 'id' DESC");
                        $data = array();
                        foreach($role as $r){
                            $data[] = $r;
                        }
                        echo json_encode([
                            'data'      => $data,
                        ]);
            
                    }else if($method=='getone'){
                        $role = $k->query("SELECT * FROM tb_role WHERE role_id='$role_id\'");
                        echo json_encode([
                            'data'      => mysqli_fetch_array($role),
                        ]);
                        
                    }
                    exit();    
                }
                
                echo json_encode([
                    'alert'     => ['class'    => 'danger', 'capt'     => 'Api key tidak valid, silahkan coba lagi!']
                ]);
            