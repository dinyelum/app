<div id=loginmodal class=modal>
    <div class='formcard modal-content'>
        <span class=close id=close onclick = "closeModal()">&times;</span>
        <form onsubmit="event.preventDefault(); <?=isset($refreshlogin) && $refreshlogin===true ? 'loginSystem(true)' : 'loginSystem()'?>;" id=loginform method=post>
            <div class='loginheader container'>
                <div class='loginheadercontent left active' onclick="tabToggle(event, 'regsection')">REGISTER</div>
                <div class='loginheadercontent left' onclick="tabToggle(event, 'loginsection')">LOGIN</div>
            </div>
            <div>
                <span id=success class=success></span>
                <span id=gen class=error></span>
            </div>
            <div id=regsection class=logincontent>
                <div class='formrow container'>
                    <div class=forminput>
                        <input type=text name=firstname value='' placeholder='First Name'>
                        <span class=error id=firstname></span>
                    </div>
                    <div class=forminput>
                        <input type=text name=lastname value='' placeholder='Last Name'>
                        <span class=error id=lastname></span>
                    </div>
                </div>
                <div class='formrow container'>
                    <div class=forminput>
                        <input type=text name=email value='' placeholder='Email'>
                        <span class=error id=email></span>
                    </div>
                    <div class=forminput>
                        <input type=text name=phone value='' placeholder='Phone Number'>
                        <span class=error id=phone></span>
                    </div>
                </div>
                <div class='formrow container'>
                    <div class=forminput>
                        <input type=password name=password value='' placeholder='Password'>
                        <span class=error id=password></span>
                    </div>
                    <div class=forminput>
                        <input type=password name=confirmpassword value='' placeholder='Confirm Password'>
                        <span class=error id=confirmpassword></span>
                    </div>
                </div>
                <div class=container>
                    <p class=right id=login onclick="tabToggle(event, 'loginsection')">Already registered? Please Login</span></p>
                    <p class=left>By registering, you accept our <a href=''>terms of use</a> and <a href=''>privacy policy</a></p>
                </div>
                <div class='formrow container'>
                    <div class='forminput forminputsubmit'>
                        <input type=submit name=submit value='Register' id=reg>
                    </div>
                </div>
            </div>
            <div id=loginsection class=logincontent style='display:none'>
                <div class='formrow container'>
                    <div class=forminput>
                        <input type=text name=email value='' placeholder='Email'>
                        <span class=error id=emailerr></span>
                    </div>
                    <div class=forminput>
                        <input type=password name=password value='' placeholder='Password'>
                        <span class=error id=passworderr></span>
                    </div>
                </div>
                <div class=container>
                    <p class=dynright><span id=register onclick="tabToggle(event, 'regsection')">Not yet a member? Register</span></p>
                    <p class=dynleft><span id=login onclick="tabToggle(event, 'passwordsection')">Forgot Password? Reset</span></p>
                </div>
                <div class='formrow container'>
                    <div class='forminput forminputsubmit'>
                        <input type=submit name=submit value='Login'>
                    </div>
                </div>
            </div>
            <div id=passwordsection class=logincontent style='display:none'>
                <div class='formrow container'>
                    <div class='forminput' style='width:98%'>
                        <input type=text name=email value='' placeholder='Email'>
                        <span class=error id=emailerr></span>
                    </div>
                </div>
                <div class=container>
                    <p class=right id=login onclick="tabToggle(event, 'loginsection')">Know your password? Login</p>
                </div>
                <div class='formrow container'>
                    <div class='forminput forminputsubmit'>
                        <input type=submit name=submit value='Reset'>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>