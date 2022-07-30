<?php
/*
 * Author: Paige A. Thompson (paigeadele@gmail.com)
 * Copyright (c) 2018, Netcrave Communications
 * All rights reserved.
 *
 *
 * Author: Trevor A. Thompson (trevorat@gmail.com)
 * Copyright (c) 2007, Progressive Solutions Inc.
 * All rights reserved.
 *
 * - Redistribution and use of this software in source and binary forms, with or without modification, are
 * permitted provided that the following conditions are met:
 * Redistributions of source code must retain the above
 * copyright notice, this list of conditions and the
 * following disclaimer.
 *
 * - Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the
 * following disclaimer in the documentation and/or other
 * materials provided with the distribution.
 *
 * - Neither the name of Progressive Solutions Inc. nor the names of its
 * contributors may be used to endorse or promote products
 * derived from this software without specific prior
 * written permission of Progressive Solutions Inc.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED
 * WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A
 * PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR
 * TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
 * ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

namespace pscr\apps\home;

use pscr\apps\home\index;
use pscr\extensions\pscr_content\html;

/**
 * Class about
 * @package pscr\apps\home
 */
class register extends index
{
    /**
     *
     */

    function __construct() {
        parent::__construct();
    }

    public function generate()
    {
        $this->generate_register_form();
    }

    function generate_register_form() {
        $section = $this->sections->div("register-form");
        $form = $section->form()
              ->action("/register")
              ->method("POST");

        $fs = $form->fieldset();
        $fs->legend()->inner_text("Register new account");

        $fs->div()->input()
            ->name("email")
            ->type("email")
            ->placeholder("email");

        $fs->div()->input()
            ->name("username")
            ->type("text")
            ->placeholder("user name");

        $fs->div()->input()
            ->name("password")
            ->type("password")
            ->placeholder("password");

        $fs->div()->input()
            ->name("password2")
            ->type("password")
            ->placeholder("password (re-enter)");

        $fs->div()->input()
            ->name("submit")
            ->type("submit")
            ->value("Register");
    }

    function process_post() {
        $this->response->add_redirect("/");
    }
}

?>
