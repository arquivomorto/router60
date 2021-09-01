<?php
//router v1.0.0
return function ($routes, $domain = false) {
    $segment=function ($segmentId = null, $domain = false) {
        $str=$_SERVER["REQUEST_URI"];
        if ($domain) {
            $path=parse_url($domain, PHP_URL_PATH);
            if (!is_null($path) and $path<>'/') {
                $str=substr($str, strlen($path));
            }
        }
        $arr=explode('/', @explode('?', $str)[0]);
        $arr=array_values(array_filter($arr));
        if (count($arr)<1) {
            $segment[1]='/';
        } else {
            $i=1;
            foreach ($arr as $key => $value) {
                $segment[$i++]=$value;
            }
        }
        if (is_null($segmentId)) {
            return $segment;
        } else {
            if (isset($segment[$segmentId])) {
                return $segment[$segmentId];
            } else {
                return false;
            }
        }
    };
    if (isset($routes[$segment(1, $domain)])) {
        $route_name=$routes[$segment(1, $domain)];
    } elseif (isset($routes['*'])) {
        $route_name=$routes['*'];
    } else {
        http_response_code(404);
        die('not found');
    }
    $route=function ($options, $segment, $domain) {
        if (isset($options['c'])) {
            $controller=function ($controller, $segment, $domain) {
                $request_method=$_SERVER['REQUEST_METHOD'];
                $filename=__DIR__.'/c/'.$controller.'.php';
                return require $filename;
            };
            $data=$controller($options['c'], $segment, $domain);
        } else {
            $data=null;
        }
        if (isset($options['v'])) {
            $view=function ($data, $view) {
                extract($data);
                return require __DIR__.'/v'.$view.'.php';
            };
            $view($data, $options['v']);
        }
    };
    return $route($route_name, $segment, $domain);
};

