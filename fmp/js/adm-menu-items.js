//Extra code to find position:
function findPos(){
	if(bw.ns4) {	// Netscape 4
		x = document.layers.layerMenu.pageX;
		y = document.layers.layerMenu.pageY;
	} else {	//other browsers
		var x = 0;
		var y = 0;
		var el;
		var temp;
		el = (bw.ie4) ? document.all["divMenu"] : document.getElementById("divMenu");
		if(el.offsetParent) {
			temp = el;
			while(temp.offsetParent) {	//Looping parent elements to get the offset of them as well
				temp = temp.offsetParent; 
				x += temp.offsetLeft;
				y += temp.offsetTop;
			}
		
		}
	x+=el.offsetLeft;
	y+=el.offsetTop;
	}
	//Returning the x and y as an array
	return [x,y];
}

pos = findPos();

//Menu object creation
myMenu=new makeCM('myMenu'); //Making the menu object. Argument: menuname

//Menu properties
myMenu.pxBetween=0;
//Using the cm_page object to place the menu ----
myMenu.fromLeft=pos[0];
myMenu.fromTop=pos[1];
//We also need to "re place" the menu on resize. So:
myMenu.onresize=eval("pos = findPos(); myMenu.fromLeft=pos[0]; myMenu.fromTop=pos[1]");

myMenu.rows=1;
myMenu.menuPlacement=0;

myMenu.offlineRoot='';
myMenu.onlineRoot=document.location.href.substring(0,document.location.href.lastIndexOf("/") +1);	//'js/';
myMenu.resizeCheck=1;
myMenu.wait=500;
myMenu.fillImg='menuha.gif';
myMenu.zIndex=0;
//var img=myMenu.onlineRoot+"images/menu/";
var img="images/menu/";

//Background bar properties
myMenu.useBar=0;
myMenu.barWidth="menu";
myMenu.barHeight="menu"; 
myMenu.barClass="clBar";
myMenu.barX="menu";
myMenu.barY="menu";
myMenu.barBorderX=0;
myMenu.barBorderY=0;
myMenu.barBorderClass='';

//Level properties - ALL properties have to be spesified in level 0
myMenu.level[0]=new cm_makeLevel() //Add this for each new level
myMenu.level[0].width=114;
myMenu.level[0].height=20;
myMenu.level[0].regClass="clLevel0";
myMenu.level[0].overClass="clLevel0over";
myMenu.level[0].borderX=0;
myMenu.level[0].borderY=0;
myMenu.level[0].borderClass="clLevel0border";
myMenu.level[0].offsetX=25;
myMenu.level[0].offsetY=0;
myMenu.level[0].rows=0;
myMenu.level[0].arrow=0;
myMenu.level[0].arrowWidth=0;
myMenu.level[0].arrowHeight=0;
myMenu.level[0].align="bottom";


//EXAMPLE SUB LEVEL[1] PROPERTIES - You have to specify the properties you want different from LEVEL[0] - If you want all items to look the same just remove this
myMenu.level[1]=new cm_makeLevel() //Add this for each new level (adding one to the number)
myMenu.level[1].width=myMenu.level[0].width+2;
myMenu.level[1].height=20;
myMenu.level[1].regClass="clLevel1";
myMenu.level[1].overClass="clLevel1over";
myMenu.level[1].borderClass="clLevel1border";
myMenu.level[1].borderX=1;
myMenu.level[1].borderY=0;
myMenu.level[1].align="right";
myMenu.level[1].offsetX=0; //-(myMenu.level[0].width-2)/2+20;
myMenu.level[1].offsetY=0;
myMenu.level[1].arrow=img+'bullet.gif';
myMenu.level[1].arrowWidth=12;
myMenu.level[1].arrowHeight=15;

//EXAMPLE SUB LEVEL[2] PROPERTIES - You have to spesify the properties you want different from LEVEL[1] OR LEVEL[0] - If you want all items to look the same just remove this
myMenu.level[2]=new cm_makeLevel() //Add this for each new level (adding one to the number)
myMenu.level[2].width=145;
myMenu.level[2].height=20;
myMenu.level[2].offsetX=0;
myMenu.level[2].offsetY=0;
myMenu.level[2].regClass="clLevel2";
myMenu.level[2].overClass="clLevel2over";
myMenu.level[2].borderClass="clLevel2border";

/******************************************
Menu item creation:
myMenu.makeMenu(name, parent_name, text, link, target, width, height, regImage, overImage, regClass, overClass , align, rows, nolink, onclick, onmouseover, onmouseout) 
*************************************/
                                                                                                                 

myMenu.makeMenu('top0','','Administrators','#index.php');

myMenu.makeMenu('top1','','Settings','#link.php');
	myMenu.makeMenu('sub10','top1','Sub category 1','#link.php');
	myMenu.makeMenu('sub11','top1','Sub category 2','#link.php');
	myMenu.makeMenu('sub12','top1','Sub category 3','#link.php','',null,30);
	myMenu.makeMenu('sub13','top1','Sub category 4','#link.php');
	
myMenu.makeMenu('top2','','Design','#link.php');

for (var loop=1; loop <= 13; loop++) {
	if (loop < 10) {
		loop = '0' + loop;
	}
	myMenu.makeMenu('subitem'+loop,'top2','Sub category'+loop,'#link.php');
	myMenu.makeMenu('sublevel'+loop+'1','subitem'+loop,'More Information','#link.php');
	myMenu.makeMenu('sublevel'+loop+'2','subitem'+loop,'Downloads','#link'+loop+'2.php');
		myMenu.makeMenu('sublevel'+loop+'3','subitem'+loop,'Create an account','#link'+loop+'3.php');
		myMenu.makeMenu('sublevel'+loop+'4','subitem'+loop,'Logout','#link'+loop+'4.php');
}

myMenu.makeMenu('top3','','Statistics','#link.php');
	myMenu.makeMenu('sub30','top3','Sub category 1','#link.php','',126);
	myMenu.makeMenu('sub31','top3','Sub category 2','#link.php','',126);
	myMenu.makeMenu('sub32','top3','Sub category 3','#link.php','',126);
	myMenu.makeMenu('sub33','top3','Sub category 4','#link.php','',126);

myMenu.makeMenu('top4','','Questions','#link.php');

myMenu.makeMenu('top5','','Categories','#link.php');
	myMenu.makeMenu('sub50','top5','Sub category 1','#link.php');
	myMenu.makeMenu('sub51','top5','Sub category 2','#link.php');

// myMenu.makeMenu('top6','','Contacts','ud.php','',91,null,img+'r07_contacts.gif',img+'r07_contacts_over.gif','','','bottomleft');
myMenu.makeMenu('top6','','Installation Code','#link.php');
	myMenu.makeMenu('sub60','top6','Information','#link.php','',135);
	myMenu.makeMenu('sub61','top6','Order on-line','#link.php','',135);
	myMenu.makeMenu('sub62','top6','Get them','#link.php','',135);
	myMenu.makeMenu('sub63','top6','Mail us','mailto:mail@domain.com','',135);

//Leave this line - it constructs the menu
myMenu.construct();