<?php

namespace app\Views;

use framework\View;

class DefaultView extends View
{
    public function renderBody(): string
    {
        $person = $this->data["person"];
        $framework = $this->data["framework"];

        return <<<HTML
            <section class="container">
                <main class="my-5 mx-2">
                    <h1>Greetings People, welcome to $framework, my Framework.</h1>
                    <hr />
                    <p>
                        I am <b>$person->name</b>, <b>$person->age</b> years old, the
                        <b>$person->role</b> of this Framework.
                    </p>
                    <p>
                        <b>Yaravel</b> is a small, yet robust PHP MVC framework that can
                        be used for both rendering HTML and as an API. It features a
                        request and routing system, a view engine with support for
                        stylesheets and javascript, and an ORM called Helloquent for
                        database communication. Yaravel is designed to be fast,
                        efficient and flexible, making it an ideal choice for developers
                        looking to build web applications with PHP.
                    </p>

                    <div class="part" id="summary">
                        <h2>Summary</h2>
                        <ul>
                            <li><a href="#routing">Routing</a></li>
                            <ul>
                                <li><a href="#web">Web Routes</a></li>
                                <li><a href="#api">API Routes</a></li>
                            </ul>
                            <li><a href="#request">Request</a></li>
                            <li><a href="#response">Response</a></li>
                            <li><a href="#mvc">MVC</a></li>
                            <ul>
                                <li><a href="#model">Model</a></li>
                                <li><a href="#view">View</a></li>
                                <li><a href="#controller">Controller</a></li>
                            </ul>
                            <li><a href="#more-info">More info</a></li>
                        </ul>
                    </div>

                    <div class="part" id="routing">
                        <h2>Routing</h2>
                        <p>
                            Your application routes can be registered in the
                            <b>"/routes"</b> folder. API routes should be placed in the
                            <b>"api.php"</b> file and web pages in the
                            <b>"web.php"</b> file.
                        </p>
                        <div id="web">
                            <h4>Web Routes</h4>
                            <p class="m-0">
                                To register a web route, use the addRoute function on
                                the router object. The function takes the following
                                parameters:
                            </p>
                            <ul class="m-0">
                                <li>path: the path after the domain name</li>
                                <li>
                                    controller path: the path to the controller file
                                </li>
                                <li>
                                    action: the function in the controller that should
                                    be executed
                                </li>
                            </ul>
                            <div class="card my-2">
                                <code class="card-body">
                                    // &#36;router->addRoute(path, controller path, action);
                                    <br />
                                    &#36;router->addRoute("/", DefaultController::class,
                                    "viewDefault");
                                </code>
                            </div>
                            <p>
                                <i>
                                    Refer to the examples in
                                    <b>"/routes/web.php"</b> for more information.
                                </i>
                            </p>
                        </div>
                        <div id="api">
                            <h4>API Routes</h4>
                            <p class="m-0">
                                To register an API route, use the api function on the
                                router object. The function takes the following
                                parameters:
                            </p>
                            <ul class="m-0">
                                <li>path: the path after the domain name</li>
                                <li>
                                    controller path: the path to the controller file
                                </li>
                                <li>
                                    method (optional, default is "GET"): the request
                                    method (can be "POST", "PUT" or "DELETE"). The
                                    controller action will have the same name as the
                                    method.
                                </li>
                            </ul>
                            <div class="card my-2">
                                <code class="card-body">
                                    // &#36;router->addRoute(path, controller path, method);
                                    <br />
                                    &#36;router->api("/", DefaultController::class);
                                    <br />
                                    &#36;router->api("/", DefaultController::class, "post");
                                </code>
                            </div>
                            <p>
                                <i>
                                    Refer to the examples in
                                    <b>"/routes/api.php"</b> for more information.
                                </i>
                            </p>
                        </div>
                    </div>

                    <div class="part" id="request">
                        <h2>Request</h2>
                        <p class="m-0">
                            The <b>&#36;this->request</b> object is included inside the
                            controllers and is an instance of the
                            <b>HttpRequest</b> class. It holds all the data from the
                            request. The object has several properties, including:
                        </p>
                        <ul>
                            <li>
                                <b>get:</b> an array that stores the data sent through
                                parameters.
                            </li>
                            <li>
                                <b>post:</b> an array that stores the data sent through
                                a POST request.
                            </li>
                            <li><b>method:</b> the method used in the request.</li>
                            <li><b>script_name:</b> the path of the current script.</li>
                            <li><b>root:</b> the root directory of the application.</li>
                            <li>
                                <b>path_info:</b> the path information trailing the
                                domain name.
                            </li>
                        </ul>
                    </div>

                    <div class="part" id="response">
                        <h2>Response</h2>
                        <p class="m-0">
                            The <b>HttpResponse</b> class is used to respond to API
                            calls. It has a static function called respond which has two
                            parameters:
                        </p>
                        <ul>
                            <li>
                                <b>content:</b> the data that will be returned to the
                                client.
                            </li>
                            <li>
                                <b>status:</b><i>(optional)</i> the response status,
                                which should be selected from the predefined statuses in
                                the status class. The default status is 200 OK.
                            </li>
                        </ul>
                    </div>

                    <div class="part" id="mvc">
                        <h2>MVC</h2>
                        <p>
                            MVC (Model-View-Controller) is a software design pattern
                            that separates an application into three main components
                        </p>
                        <div id="model">
                            <h4>Model</h4>
                            <p>
                                The Model component in the framework is responsible for
                                handling data and business logic, and for communicating
                                with the database. This is done through the use of
                                <code>Hellowoquent</code>, an ORM tool specifically
                                built for the framework. For further details, refer to
                                the <code>Hellowoquent</code> documentation. Models
                                should be stored in the
                                <code>/app/Models</code> directory and should extend the
                                <code>Model</code> class (as demonstrated by the
                                <code>Person</code> class in the code).
                            </p>
                        </div>

                        <div id="view">
                            <h4>View</h4>
                            <p>
                                The View component contains functions that return HTML
                                mixed with data to be displayed to the user. The data
                                used can be passed from the Controller and can be
                                accessed via the
                                <code>&#36;this-&gt;data</code> attribute(array). Views
                                should be stored in the
                                <code>/app/views</code> directory and should extend the
                                <code>View</code> class (as demonstrated by the
                                <code>DefaultView</code> or
                                <code>ErrorView</code> classes in the code).
                            </p>
                        </div>

                        <div id="controller">
                            <h4>Controller</h4>
                            <p>
                                Revised Text: The Controller component handles user
                                input and updates the Model and View accordingly.
                                Controllers should be stored in the
                                <code>/app/Controllers</code> directory and should
                                extend the <code>Controller</code> class. It has a
                                property <code>&#36;this-&gt;request</code> that contains
                                data from the incoming request. To respond as a web
                                page, a View should be defined and the
                                <code>render</code> function of that View should be
                                called, such as
                                <code>&#36;view-&gt;render("renderBody")</code>. To respond
                                to an API call, the <code>respond</code> function from
                                the <code>HttpResponse</code> class should be used, for
                                example <code>HttpResponse::respond(&#36;data)</code>. See
                                the <code>DefaultController</code> for an example.
                            </p>
                        </div>
                    </div>

                    <div class="part" id="more-info">
                        <h2>Further information</h2>
                        <p>
                            The application starts with the index.php file. Firstly, the
                            request is constructed, followed by the registration of CSS
                            and JS. Next, the app configuration and database
                            configuration are initialized, and then the router is set
                            up. Finally, the app is executed by calling
                            <code>&#36;router->run();</code>
                            <i>(see index.php file for more info)</i>
                        </p>
                        <p>
                            This framework is licensed under the MIT License, which is a
                            permissive open-source license that allows for the use,
                            modification, and distribution of the software. The MIT
                            License allows for a high degree of flexibility in how the
                            software can be used and incorporates a minimal set of
                            restrictions.
                        </p>
                    </div>
                </main>
            </section>
        HTML;
    }
}
