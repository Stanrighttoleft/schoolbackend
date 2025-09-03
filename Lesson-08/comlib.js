function rand(min, max){
            //Math.random(), JS產生0-1之間的隨機函數,包含0不包含1之間的值
            //Math.floor()函數會回傳無條件捨去
            //Math.ceil()函數會回傳無條件進位
            min=Math.ceil(min);
            max=Math.floor(max);
            return Math.floor(Math.random()*(max-min+1)+min);
            //回傳min到max之間的值

            /* rand(5,10)
            return 最小返回5 ,Math.floor(0*(10-5+1)+5)
            return 最大返回10, Math.floor(0.9*(10-5+1)+5)
             */
        }
function addZero(x){
            return((x<10) ?"0"+x :x);
        }
        
function arrangeseatrow(seat){
    if(seat<17){
        row=Math.floor(seat/8);
        if(row===(seat/8)){
            return row;
        }else{return row+1;}      
        
        
    }else if(seat>=17){
        row=Math.floor((seat+1)/8);
        if(row===((seat+1)/8)){
            return row;
        }else{return row+1;}
        
    }
}
function arrangeseat(seat){
    if(seat<17){
        place=seat%8;
        if(place===0){
            place=8
        }
    return place;
    }else if(seat===17){

    }
    
    else{
        place=(seat+1)%8;
        if(place===0){
            place=8
        }
        return place;
    }
} 
 
// 老師的解答

// function setSeat(number){
//     if(number===17){
//         newRow=4;
//         newCol=8;
//     }
//     if(number>=17){
//         number++
//     }
//     newRow=Math.ceil(number/8);
//     if((number%8)==0){
//         newCol=8
//     }else{
//         newCol=(number%8)
//     }
//     return("教室位置為"+newRow+"排，第"+newCol+"位")
    
// }
