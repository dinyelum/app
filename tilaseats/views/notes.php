<?php include "../app/excelwrite/incs/header.php"?>
<style>
    .writeup {
        width: 75%;
        margin: 5% auto;
    }
    .writeup h1, .writeup h2, .writeup h3 {
        margin-bottom: 1%;
    }
    .writeup dt {
        font-weight: bold;
        margin-top: 1%;
    }
    .writeup dd {
        margin-bottom: 1%;
    }
</style>
<section>
    <div class=writeup>
        <h1>Quick Overview</h1>
        <p>Whenever a new writer joins the website, the admin is notified.
        The admin is expected to evaluate the writer to know if he / she is someone he can work with.</p>
        <p>The admin then instructs the writer to select subjects of specialization on his profile page and if there's a subject the writer specialises in that is not yet listed, the admin would use the Add Subjects page via the Admin dashboard to add that subject.</p>
        
        <p>Whenever there's a new Order, the admin is notified too.
        He chooses to do the assignment himself or outsource to an available writer.
        For orders that currently cannot be handled for one reason or the other, he would let the Client know and would also use the Order Page on the admin dashboard to cancel the order.</p>
        
        <p>The contact page on the Admin Panel is used to manage contacts channels.<br>
        Just as Order Page is used for Orders<br>
        Writer Page for Writers and:<br>
        Suject Page for Subjects</p>
        
        
        <p>Active - 0: means inactive.<br>
        Active - 1: means active.</p>
        
        <h2>Orders</h2>
        <p>The Orders displayed are sorted according to their status (open to finished) and according to their deadline too (nearer / past deadlines are ranked first, before farther ones).</p>
        <h3>Adding New Orders</h3>
        <p>You cannot add orders manually. It has to be done using the Submit Assignment form.</p>
        
        <h3>Editing Orders</h3>
        <h4>Order Substatus:</h4>
        <dl>
            <dt>Not Started:</dt>
            <dd>Default Substatus for every new Order.</dd>
            
            <dt>Awaiting Approval:</dt>
            <dd>Payment has been made but admin has connfirmed the payment.</dd>
            
            <dt>Order Approved:</dt>
            <dd>Payment has been confirmed</dd>
            
            <dt>On the Way:</dt>
            <dd>Order is almost complete.</dd>
            
            <dt>Canceled:</dt>
            <dd>Order was canceled</dd>
            
            <dt>Order Complete:</dt>
            <dd>Order has been completed and delivered to the customer.</dd>
        </dl>
        <h4>Additional Note (Optional):</h4>
        <p>Anything the admin feels like. Whatever is written here can be viewed by the customer.</p>
        
        <h2>Upgrades:</h2>
        <p>Automation of Order Process, Customers can create and cancel orders by themselves.</p>
        <p>Customers also have the right to choose a specific writer.</p>
        <p>Integration of a Payment Gateway.</p>
        <p>When there is an order, notify all writers who specialize in the subject, the writers have a choice to accept or decline. The first writer to accept, works with the order.</p>
    </div>
</section>

<!--<p>When there are more than 20 subjects, say 30, 40, 50 or more, uncomment the Read More Paragraph and use this code block to make the subject list display bit by bit on mobile devices, instead of showing 50 items (25 / 50 rows) at the same time. </p>-->
<!--<script>
    //projects lists readmore
    var readmore = document.getElementById('readmore'); 
    var listsections = document.getElementsByClassName('listsection');
    var device = window.matchMedia("(max-width: 600px)");
    if(device.matches) {
    	for(let i=0; i<listsections.length; i++) {
    		ullist = listsections[i].getElementsByClassName('list');
    		for(let j=0; j<ullist.length; j++) {
    			if(j>0) {
    				ullist[j].classList.add('none');
    			}
    		}
    	}
    	var ullist, curlist;
    	var next = 0;
    	var hiddenul = document.querySelectorAll('.listsection ul.none').length;
    	if(hiddenul) {
    		readmore.style.display = 'block';
    	}
    	readmore.addEventListener('click', function(e) {
    		next++;
    		for(let i=0; i<listsections.length; i++) {
    			curlist = listsections[i].querySelector('ul.list'+next);
    			if(curlist) {
    				curlist.classList.remove('none');
    			}
    			if(next >= Math.ceil(hiddenul/2)) {
    				this.style.display = 'none';
    			} else {
    				console.log('next is: '+next+' and hiddenul count is: '+hiddenul);
    			}
    		}
    	});
    } else {
    	readmore.style.display = 'none';
    }
</script>-->
<?php include "../app/excelwrite/incs/footer.php"?>