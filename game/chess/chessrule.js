/****************************************棋子的算法************************************/
/****************chess代表棋子，from代表棋子的原坐标，to代表棋子的目的坐标**************/
function check(chess, from, to){               //定义的函数名及参数，函数中代码用来控制各棋子的走法
    /**************************************控制黑棋“卒”的走法**********************************/
    if(chess == "011" || chess == "012" || chess == "013" || chess == "014" || chess == "015"){
        if(from >= 46 && (from - to == 1 || to - from == 1))      //黑棋“卒”过河后可以横向走
            return 1;                          //返回值为1
        if(to - from == 9)                   //如果目的坐标减去原始坐标等于9，说明向直下方走一步
            return 1;                       //返回值为1
    }
    /*************************************红棋“卒”的算法***********************************/
    if(chess == "111" || chess == "112" || chess == "113" || chess == "114" || chess == "115"){
        if(from <= 45 && (from - to == 1 || to - from == 1))      //红棋“卒”过河后可以横向走
            return 1;            //返回值为1
        if(from - to == 9)       //如果原始坐标减去目的坐标等于9，说明向直上方走一步
            return 1;             //返回值为1
    }
    /*****************************************“炮”的算法*********************************/
    if(chess == "010" || chess == "009" || chess == "110" || chess == "109") {    //如果当前的移动棋子为“炮”
        if (to - from > 0 && (to - from) % 9 == 0) {                     //控制“炮”向下走
            var count = 0;                //定义变量用于存储原始坐标和目的坐标之间棋子的数量
            for (var i = from + 9; i < to; i += 9) {      //原始坐标的值每次循环加9
                if (document.getElementById("chess_value_" + i).value != "blank")  //如果该处棋子的值不等于blank
                    count++;                        //变量自动加1
            }
            if (count == 0 && document.getElementById("chess_value_" + to).value == "blank") //如果“炮”的行进方向上没有棋子
                return 1; //返回值为1
            if (count == 1 && document.getElementById("chess_value_" + to).value != "blank") //如果“炮”的行进方向上有一个棋子
                return 1; //返回值为1
        }
        if(from - to > 0 && (from - to) % 9 == 0){           //控制“炮”向上走
            var count = 0;       //定义变量用于存储原始坐标和目的坐标之间棋子的数量
            for(var i = to + 9;i < from;i += 9){   //目的坐标的值每次循环加9
                if(document.getElementById("chess_value_"+i).value != "blank") //如果该处棋子的值不等于blank
                    count ++;        //变量自动加1
            }
            if(count == 0 && document.getElementById("chess_value_"+to).value == "blank")//如果“炮”的行进方向上没有棋子
                return 1;  //返回值为1
            if(count == 1 && document.getElementById("chess_value_"+to).value != "blank")//如果“炮”的行进方向上有一个棋子
                return 1;  //返回值为1
        }
        if(to - from > 0 && to - from < 9){             //控制“炮”向右走
            var count = 0;    //定义变量用于存储原始坐标和目的坐标之间棋子的数量
            for(var i = from + 1;i < to;i ++){ //原始坐标的值每次循环加1
                if(document.getElementById("chess_value_"+i).value != "blank")    //如果该处棋子的值不等于blank
                    count ++;              //变量自动加1
            }
            if(count == 0 && document.getElementById("chess_value_"+to).value == "blank") //如果“炮”的行进方向上没有棋子
                return 1;  //返回值为1
            if(count == 1 && document.getElementById("chess_value_"+to).value != "blank") //如果“炮”的行进方向上有一个棋子
                return 1;  //返回值为1
        }
        if(from - to > 0 && from - to < 9){       //控制“炮”向左走
            var count = 0;    //定义变量用于存储原始坐标和目的坐标之间棋子的数量
            for(var i = to + 1;i < from;i ++){ //目的坐标的值每次循环加1
                if(document.getElementById("chess_value_"+i).value != "blank")    //如果该处棋子的值不等于blank
                    count ++;           //变量自动加1
            }
            if(count == 0 && document.getElementById("chess_value_"+to).value == "blank")//如果“炮”的行进方向上没有棋子
                return 1;  //返回值为1
            if(count == 1 && document.getElementById("chess_value_"+to).value != "blank")//如果“炮”的行进方向上有一个棋子
                return 1;  //返回值为1
        }
    }
    /****************************************“车”的算法************************************/
    if(chess == "008" || chess == "007" || chess == "108" || chess == "107") {    //如果当前的移动棋子为“车”
        if (to - from > 0 && (to - from) % 9 == 0) {                     //控制“车”向下走
            var count = 0;    //定义变量用于存储原始坐标和目的坐标之间棋子的数量
            for (var i = from + 9; i < to; i += 9) {      //原始坐标的值每次循环加9
                if (document.getElementById("chess_value_" + i).value != "blank")     //如果该处棋子的值不等于blank
                    count++;               //变量自动加1
            }
            if (count == 0)       //如果“车”的行进方向上没有棋子
                return 1;     //返回值为1
        }
        if(from - to > 0 && (from - to) % 9 == 0){        //控制“车”向上走
            var count = 0;    //定义变量用于存储原始坐标和目的坐标之间棋子的数量
            for(var i = to + 9;i < from;i += 9){      //目的坐标的值每次循环加9
                if(document.getElementById("chess_value_"+i).value != "blank")  //如果该处棋子的值不等于blank
                    count ++;              //变量自动加1
            }
            if(count == 0)    //如果“车”的行进方向上没有棋子
                return 1;     //返回值为1
        }
        if(to - from > 0 && to - from < 9){       //控制“车”向右走
            var count = 0;    //定义变量用于存储原始坐标和目的坐标之间棋子的数量
            for(var i = from + 1;i < to;i ++){ //原始坐标的值每次循环加1
                if(document.getElementById("chess_value_"+i).value != "blank")    //如果该处棋子的值不等于blank
                    count ++;                 //变量自动加1
            }
            if(count == 0)    //如果“车”的行进方向上没有棋子
                return 1;     //返回值为1
        }
        if(from - to > 0 && from - to < 9){       //控制“车”向左走
            var count = 0;    //定义变量用于存储原始坐标和目的坐标之间棋子的数量
            for(var i = to + 1;i < from;i ++){    //目的坐标的值每次循环加1
                if(document.getElementById("chess_value_"+i).value != "blank")    //如果该处棋子的值不等于blank
                    count ++;              //变量自动加1
            }
            if(count == 0)    //如果“车”的行进方向上没有棋子
                return 1;     //返回值为1
        }
    }
    /*****************************************“马”的算法***********************************/
    if(chess == "006" || chess == "005" || chess == "106" || chess == "105"){     //如果当前的移动棋子为“马”
        if(to - from == 19 || to - from == 17){            //控制“马”向下走“日”字
            if(document.getElementById("chess_value_"+(from + 9)).value == "blank")//如果原始坐标点的直下方是空棋
                return 1;     //返回值为1
        }
        if(from - to == 19|| from - to == 17){       //控制“马”向上走“日”字
            if(document.getElementById("chess_value_"+(from - 9)).value == "blank")//如果原始坐标点的直上方是空棋
                return 1;     //返回值为1
        }
        if(to - from == 7 || from - to == 11){    //控制向左横走“日”字
            if(document.getElementById("chess_value_"+(from - 1)).value == "blank")    //如果原始坐标点左侧是空棋
                return 1;     //返回值为1
        }
        if(from - to == 7 || to - from == 11){    //控制向右横走 “日”字
            if(document.getElementById("chess_value_"+(from + 1)).value == "blank")    //如果原始坐标点右侧是空棋
                return 1;     //返回值为1
        }
    }
    /***************************************“象”的算法**************************************/
    if(((chess == "004" || chess == "003") && to <= 45) || ((chess == "104" || chess == "103") && to >= 46)){
//如果当前的移动棋子为“象”
        if(to - from == 16){                                     //控制“象”向左下走
            if(document.getElementById("chess_value_"+(from + 8)).value == "blank")       //如果原始坐标点加8是空棋
                return 1;     //返回值为1
        }
        if(from - to == 16){                                    //控制“象”向右上走
            if(document.getElementById("chess_value_"+(from - 8)).value == "blank")    //如果原始坐标点减8是空棋
                return 1;     //返回值为1
        }
        if(to - from ==20){           //控制“象”向右下走
            if(document.getElementById("chess_value_"+(from + 10)).value == "blank")   //如果原始坐标点加10是空棋
                return 1;     //返回值为1
        }
        if(from - to == 20){                                 //控制“象”向左上走
            if(document.getElementById("chess_value_"+(from - 10)).value == "blank")   //如果原始坐标点减10是空棋
                return 1;     //返回值为1
        }
    }
    /*************************************黑棋“士”的算法***********************************/
    if(chess == "002" || chess == "001"){     //如果当前的移动棋子为黑棋“士”
        if((to == 6 || to == 4 || to == 14 || to == 22 || to == 24) && (to - from == 8 || from - to == 8 || to - from == 10 || from - to == 10)) //控制黑棋“士”的走法(所走范围在4、6、14、22、24点)，不能超过8个或10个坐标点
            return 1;     //返回值为1
    }
    /*************************************红棋“士”的算法***********************************/
    if(chess == "102" || chess == "101"){        //如果当前的移动棋子为红棋“士”
        if((to == 85 || to == 87 || to == 77 || to == 69 || to == 67) && (to - from == 8 || from - to == 8 || to - from == 10 || from - to == 10)) //控制红棋“士”的走法(所走范围在67、69、77、85、87点)，不能超过8个或10个坐标点
            return 1;     //返回值为1
    }
    /**************************************黑棋“将”的算法**********************************/
    if(chess == "000"){          //如果当前的移动棋子为黑棋“将”
        if(((to >= 4 && to <= 6) || (to >= 13 && to <= 15) || (to >= 22 && to <= 24)) && (to - from == 1 || from - to == 1 || to - from == 9 || from - to == 9))   //控制黑棋“将”的走法
            return 1;     //返回值为1
        if(to > from && (to - from) % 9 == 0 && document.getElementById("chess_value_"+to).value == "100"){               //如果黑棋“将”原始坐标点与红棋“帅”在一条直线上
            var count = 0; //定义变量用于存储原始坐标和目的坐标之间棋子的数量
            for(var i = from + 9;i < to;i += 9){      //黑棋“将”原始坐标点每次循环加9
                if(document.getElementById("chess_value_"+i).value != "blank")//如果该处棋子的值不等于blank
                    count ++;        //变量自动加1
            }
            if(count == 0)          //如果count变量值为0，则说明原始坐标和目的坐标之间没有棋子
                return 1;  //返回值为1，即黑棋“将”可以吃掉红棋“帅”
        }
    }
    /**************************************红棋“帅”的算法**********************************/
    if(chess == "100"){       //如果当前的移动棋子为红棋“帅”
        if(((to <= 87 && to >= 85) || (to <= 78 && to >=76) || (to <= 69 && to >= 67)) && (to - from == 1 || from - to == 1 || to - from == 9 || from - to == 9)) //控制红棋“帅”的走法
            return 1;  //返回值为1
        if(from > to && (from - to) % 9 == 0 && document.getElementById("chess_value_"+to).value == "000"){ //如果红棋“帅”原始坐标点与黑棋“将”在一条直线上
            var count = 0; //定义变量用于存储原始坐标和目的坐标之间棋子的数量
            for(var i = to + 9;i < from;i += 9){    //红棋“帅”目的坐标点每次循环加9
                if(document.getElementById("chess_value_"+i).value != "blank")//如果该处棋子的值不等于blank
                    count ++;     //变量自动加1
            }
            if(count == 0)             //如果count变量值为0，则说明原始坐标和目的坐标之间没有棋子
                return 1;  //返回值为1，即红棋“帅”可以吃掉黑棋“将”
        }
    }
    return 0;
}
