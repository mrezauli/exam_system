var createGroupedArray = function(arr, chunkSize) {
    var groups = [], i;
    for (i = 0; i < arr.length; i += chunkSize) {
        groups.push(arr.slice(i, i + chunkSize));
    }
    return groups;
}

function escapeRegExp(string){
  return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
}

//s = s.substr(0, index) + 'x' + s.substr(index + 1);

// var groupedArr = createGroupedArray(question, 20);
// var result = JSON.stringify(groupedArr);

// var html = $('p').html();
// $('p').html(html.replace(/world/gi, '<strong>$&</strong>'));

function getPosition(string, subString, index) {
   return string.split(subString, index).join(subString).length;
}


function getIndex(array, key, position) {

  var counter =0;
  var vvv =0;

  
  $(array).each(function(index, el) {


       // console.log(index);

    if (el == key) {
        //console.log(index);

      counter++;

    }

        //console.log(counter);

    //console.log(position);


    if (counter == position) {
      //console.log(counter,position,index);

      vvv = index;
      return false;
      //console.log(counter,position,index);
    
    }

   

});

    return vvv;


}





var reportRecipients = ['AAA', 'XYZ', 'AAA', 'ABC','AAA', 'XXX', 'XYZ', 'PQR'];



function unique_array(array){


  var array = array.sort(); 

  var ggg = {};


  for (var i = 0; i < array.length; i++) {

   if (i == 0) {

     ggg[ array[i] ] = 1;

   }



      if (array[i] == array[i - 1]) {

       ggg[ array[i] ] = ggg[ array[i] ]+1;

        // console.log(i + 'aaa');
        // console.log(array[i]);
        // console.log(ggg[ array[i] ]);


      }else{

       ggg[ array[i] ] = 1;

      }

  }

return ggg;

}




function diffString(question,answer){




 // ttt = question = question.replace(/\s+$/, '');
 // answer = answer.replace(/\s+$/, '');


 q1= (question == "") ? [] : question.split(/\s+/);

 question = (question == "") ? [] : question.split(/\s+/);
 
 a1 = (answer == "") ? [] : answer.split(/\s+/);

 answer = (answer == "") ? [] : answer.split(/\s+/);

 







 unique_question = unique_array(q1);

 unique_answer = unique_array(a1);

 //console.log(unique_answer,'pppppp');


var difference = $(Object.keys(unique_question)).not(Object.keys(unique_answer)).get();


$(difference).each(function(index, el) {
  
  unique_answer[el] = 0;

});


var new_words = [];
var deleted_words = [];

for (var key in unique_answer) {

  var errors = [];

  //console.log(key, unique_answer[key]);

 var entries = unique_question[key] - unique_answer[key];
 //console.log(unique_question[key],unique_answer[key],'kkkkkkkkk');
 //console.log(entries);

  if (entries > 0) {
  

    for (var i = 1; i < entries + 1; i++) {

   // console.log(unique_answer[key] + i);
   
      
//var eee = getPosition(ttt, key, unique_answer[key] + i); // --> 16



eee = getIndex(question, key, unique_answer[key] + i); // --> 16

errors.push(eee);
deleted_words.push(eee);
//console.log(question);
//console.log(errors);

// var jjj = eee;

// question[eee] = null;

// console.log(question);

//  console.log(question);

}


}else if(isNaN(entries)){


new_words.push(key);
//console.log('ttttttttttttttttt');
//console.log(new_words,'llllllllllll');

}



      $(errors).each(function(index, el) {
        
        question[el] = '<span style="background:#ccc;">' + key + '</span>';

      });

      var joined_question = question.join(' ');

      //console.log(new_words,'llllllllllll');
      $(new_words).each(function(index, el) {
        
        joined_question = joined_question + ' ' + '<span style="background:#ccc;">' + el + '</span>';

      });

      errors = [];

      //console.log(new_words);

  }






$('#answered_text').after(joined_question);
$('#answered_text').after('new_words:' + new_words.length + ' ');
$('#answered_text').after('deleted_words:' + deleted_words.length + ' ');
$('#answered_text').after('--------------------------' + '<br>');
}





//  var string = "lorem ipsum dolor lorem sdsd lorem";
//  var eee = getPosition(string, 'lorem', 2) // --> 16





// console.log(eee);








// result: "[[1,2,3,4],[5,6,7,8],[9,10,11,12],[13,14]]"