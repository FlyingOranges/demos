<?php

header("Content-Type:text/html;charset=utf-8");

class HttpUrl
{
    /*
     *  请求一个外部地址要进行一下操作(请求外部接口)
     *      1.创建一个新的cURL资源
     *          $ch = curl_init();
     *      2.设置url和相应的选项
     *          具体看下面示例(POST和GET的设置不完全相同)
     *      3.抓取URL并把它传递给浏览器
     *          $output = curl_exec($ch);
     *            执行一个cURL会话,成功时返回 TRUE,或者在失败时返回 FALSE.
     *          如果 CURLOPT_RETURNTRANSFER选项被设置,函数执行成功时会返回
     *          执行的结果,失败时返回 FALSE
     *      4.关闭cURL资源，并且释放系统资源
     *          curl_close($ch);
     */

    /*
     * $url   接口地址
     * $array  传入的参数(数组)
     */
    protected function getPostData($url, $array)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);    //需要获取的URL地址,也可以在 curl_init()函数中设置
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    //将 curl_exec()获取的信息以文件流的形式返回,而不是直接输出
        curl_setopt($ch, CURLOPT_POST, 1);  //发送一个POST请求
        curl_setopt($ch, CURLOPT_POSTFIELDS, $array);   //全部数据使用HTTP协议中的"POST"操作来发送
        $output = curl_exec($ch);
        curl_close($ch);
        if ($output) {
            return $output;
        } else {
            return false;
        }
    }

    /*
     * $url    接口地址
     */
    protected function getGetData($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);    //该设置会将头文件信息作为数据流输出
        $output = curl_exec($ch);
        curl_close($ch);
        if ($output) {
            return $output;
        } else {
            return false;
        }
    }

    //  对传入的url进行合法性判断
    private function check_url($url)
    {
        if (!preg_match('/http:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is', $url)) {
            if (!preg_match('/https:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is', $url)) {
                return false;
            }
        }
        return $url;
    }

    /*
     * 外部调用该方法实现POST方式请求外部地址
     * $url     外部地址
     * $array   POST带的参数(数组形式)
     */
    public function RequestPost($url, $array)
    {
        $Result_Array = (is_array($array)) ? $array : false;
        if (!$Result_Array) {
            return false;
        }
        $Result_Url = $this->check_url($url);
        if (!$Result_Url) {
            return false;
        }
        $result = $this->getPostData($Result_Url, $Result_Array);
        return json_decode($result);
    }

    /*
     * 外部调用该方法实现GET方式请求外部地址
     * $url     外部地址
     */
    public function RequestGet($url)
    {
        $Result_Url = $this->check_url($url);
        if (!$Result_Url) {
            return false;
        }
        $result = $this->getGetData($Result_Url);
        return json_decode($result);
    }

}