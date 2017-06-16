<!-- functions :::
// written or changed by Elf.
// elf@ua.fm

   var d=document.all,
       curTextEl,
       bad_types,
       required_pref;


//-----------------------------------------------
/*
   function switchBlock_SaveUpdate(Ind) {
      is_block_1=false;
      is_block_2=false;

      if (Ind==1) is_block_1=true;
      if (Ind==2) is_block_2=true;

      document.all.item("block_1",0).style.display = is_block_1 ? "":"none";
      document.all.item("block_2",0).style.display = is_block_2 ? "":"none";
   }
*/


function storeCaret(textEl, req_pref, b_types) {
   if (textEl.createTextRange) {
      textEl.caretPos = document.selection.createRange().duplicate();
   }
   curTextEl=textEl;
   required_pref=req_pref;
   bad_types=b_types;

}


function insCode(text, field_type, tpl_type) {
   var txtarea;

   if (curTextEl) {
      txtarea=curTextEl;

   } else if ('log_tpl'==tpl_type) {
      txtarea = document.template_form.body;
      bad_types = "file";

   } else if ('mail_tpl'==tpl_type) {
      //txtarea = document.formm.bodyf;
      //bad_types = "file";

   } 


   if ('db_tpl'==tpl_type) {
      bad_types = "file";
   }


   if ( bad_types.indexOf(field_type) != -1 ) {
      if (required_pref=="e" && (field_type=='select' || field_type=='multiple' || field_type=='checkbox' || field_type=='radio')) {
         alert("There are bad email values between field values");
      } else {
         alert("Unacceptable type for chosen template field");
      }

   } else if (txtarea) {
      text = text;

      if ('db_tpl'==tpl_type) {
         txtarea.value = text;
         txtarea.focus();

      } else if (txtarea.createTextRange && txtarea.caretPos) {
         var caretPos = txtarea.caretPos;
         caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
         txtarea.focus();

      } else {
         txtarea.value  += text;
         txtarea.focus();
      }
   }   

}
//-->
