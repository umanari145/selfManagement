$(function() {

	//パターン追加時の処理
	$('#addPattern').click(function(){

		var task_row_no = $('tr.task_row').size();

		var next_task_row_no = parseInt( task_row_no )+1;

		//全パターン数
		var task_row_no = $('tr.task_row').size();
		//登録予定のパターンの番号
		var next_task_row_no = parseInt( task_row_no )+1;

		//元のHTMLデータ
		var originalHtmlData = $('tr#task_row_1').html();

		//追加予定のHTMLを取得後、置換
		var addHtmlData = originalHtmlData.replace(/_1/g,"_"+next_task_row_no );
		addHtmlData = addHtmlData.replace(/パターン1/g,"パターン"+next_task_row_no );
		addHtmlData = '<tr class="task_row" id="task_row_'+next_task_row_no+'">' + addHtmlData + '</tr>' ;            

		//既存の行の次に追加
		$('tr#task_row_'+task_row_no).after(addHtmlData);

		var objNewRow = $('#task_row_'+ next_task_row_no );
		//新しい行の初期化
		initNewRowData( next_task_row_no );

	});

	//削除ボタンを押したときはrowを丸ごと削除
	$(document).on('click','.delete_task_button',function(){
			var objButton = this;
			var row_no = objButton.id.split('_')[3];
			$('tr#task_row_'+row_no).remove();
			//番号を新しく振りなおす
			updateRowNo();

	})

});

/* ------------------------------------------------------------*/
// 新しい行のデータを初期化する
// 既存のRowのデータを消す
// @param  integer next_task_row_no   
//
/*--------------------------------------------------------------*/

function initNewRowData( next_task_row_no )
{
    var objSele  = $('#task_row_' + next_task_row_no + ' select ');
    var objInput = $('#task_row_' + next_task_row_no + ' input ');

    var objSele_len = objSele.length;

    //selectの値を初期化
    for( var i = 0; i < objSele_len;i++ )
    {
        var id = objSele[i].id;
        //classcategory_id2だけは空白、初期化
        //それ以外はunselected 
        if( id === 'classcategory_id2_' + next_task_row_no )
        {
            objSele[i].value='';
        }
        else
        {
            objSele[i].value='__unselected';
        }
    }

    //task_class_idをクリア
    $('#task_class_id_' + next_task_row_no ).val('');
    //数量をクリア
    $('input#quantity_' + next_task_row_no ).val(0);
    $('input#quantity_' + next_task_row_no ).css('background-color','#3f3b3a');

    //task_codeの初期化
    $('#sp_task_full_code_' + next_task_row_no ).html('');

}

/* ------------------------------------------------------------*/
// Rowの番号を振りなおす 
// 既存のRowのデータを消す
//
/*--------------------------------------------------------------*/

function updateRowNo()
{
    var objTable = $('tr.task_row');

    var objTableLen = objTable.length;

    for( var i=0; i < objTableLen; i++)
    {
        var id = objTable[i].id.split('_')[2];
        var row_no = i+1;

        //idが1以上のの時に対応
        if( id > 1 )
        {
            //値の変換とvalueの取得
            var tableHtml = $('tr#task_row_' +id).html();
            tableHtml = tableHtml.replace(/パターン[0-9]/g, "パターン"+row_no ); 
            tableHtml = tableHtml.replace(/\_[0-9]/g, "_"+row_no ); 

            var sele1 = $('select#classcategory_id1_'+id).val();
            var sele2 = $('select#classcategory_id2_'+id).val();
            var box_color = $('select#box_color_'+id).val();
            var quantity = $('input#quantity_'+id).val();

            //既存の行を削除し、新しいものに置き換える
            $('tr#task_row_'+id).remove();
            tableHtml = '<tr class="task_row" id="task_row_'+row_no+'">' + tableHtml + '</tr>' ;            
            var prev_row_no = row_no - 1;
            $('tr#task_row_'+prev_row_no).after(tableHtml);

            //値の挿入
            if( sele1 !== undefined ) $('select#classcategory_id1_'+row_no).val( sele1 );
            if( sele2 !== undefined ) $('select#classcategory_id2_'+row_no).val( sele2 );
            if( box_color !== undefined ) $('select#box_color_'+row_no).val( box_color );
            if( quantity !== undefined ) $('input#quantity_'+row_no).val( quantity );
        }

    }

}
