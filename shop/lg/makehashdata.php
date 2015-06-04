<?php
include_once('./_common.php');

// LG유플러스 공통 설정
require_once(G5_SHOP_PATH.'/settle_lg.inc.php');

/*
 * 1. 기본결제 인증요청 정보 변경
 *
 * 기본정보를 변경하여 주시기 바랍니다.(파라미터 전달시 POST를 사용하세요)
 */
$LGD_OID            = $_POST['LGD_OID'];           //주문번호(상점정의 유니크한 주문번호를 입력하세요)
$LGD_AMOUNT         = $_POST['LGD_AMOUNT'];        //결제금액("," 를 제외한 결제금액을 입력하세요)
$LGD_TIMESTAMP      = $_POST['LGD_TIMESTAMP'];     //타임스탬프

/*
 *************************************************
 * 2. MD5 해쉬암호화 (수정하지 마세요) - BEGIN
 *
 * MD5 해쉬암호화는 거래 위변조를 막기위한 방법입니다.
 *************************************************
 *
 * 해쉬 암호화 적용( LGD_MID + LGD_OID + LGD_AMOUNT + LGD_TIMESTAMP + LGD_MERTKEY )
 * LGD_MID          : 상점아이디
 * LGD_OID          : 주문번호
 * LGD_AMOUNT       : 금액
 * LGD_TIMESTAMP    : 타임스탬프
 * LGD_MERTKEY      : 상점MertKey (mertkey는 상점관리자 -> 계약정보 -> 상점정보관리에서 확인하실수 있습니다)
 *
 * MD5 해쉬데이터 암호화 검증을 위해
 * LG유플러스에서 발급한 상점키(MertKey)를 환경설정 파일(lgdacom/conf/mall.conf)에 반드시 입력하여 주시기 바랍니다.
 */

$xpay = new XPay($configPath, $CST_PLATFORM);

// Mert Key 설정
$xpay->set_config_value('t'.$LGD_MID, $config['cf_lg_mert_key']);
$xpay->set_config_value($LGD_MID, $config['cf_lg_mert_key']);

$xpay->Init_TX($LGD_MID);
$LGD_HASHDATA = md5($LGD_MID.$LGD_OID.$LGD_AMOUNT.$LGD_TIMESTAMP.$xpay->config[$LGD_MID]);
/*
 *************************************************
 * 2. MD5 해쉬암호화 (수정하지 마세요) - END
 *************************************************
 */
die($LGD_HASHDATA);
?>