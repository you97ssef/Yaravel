<?php

namespace app\Views;

use framework\View;
use framework\utils\Router;

class DefaultView extends View
{
    public function renderBody(): string
    {
        $person = $this->data["person"];
        $framework = $this->data["framework"];

        $people = $this->data["people"];

        $people_html = "";
        foreach ($people as $value) {
            $people_html .= <<<HTML
                    <tr>
                        <th scope="row">$value->id</th>
                        <td>$value->name</td>
                        <td>$value->age</td>
                        <td>$value->role</td>
                    </tr>
                HTML;
        }

        $adding_name_route = Router::urlFor($this->http, "/AddName");

        return <<<HTML
            <section class="container">
                <main class="my-5 mx-2">
                    <h1>Greetings People, welcome to $framework, my Framework.</h1>
                    <hr />
                    <p>
                        I am <a class="link-dark" href="https://youssefb.netlify.app/">$person->name</a>,
                        <b>$person->age</b> years old, the
                        <b>$person->role</b> of this Framework.
                    </p>
                    <p>
                        <b>Yaravel</b> is a small, yet robust PHP MVC framework that can
                        be used for both rendering HTML and as an API. It features a
                        request and routing system, a view engine with support for
                        stylesheets and javascript, and an ORM called 
                        <a href="https://github.com/you97ssef/Helloquent">Helloquent</a> 
                        for database communication. Yaravel is designed to be fast,
                        efficient and flexible, making it an ideal choice for developers
                        looking to build web applications with PHP.
                    </p>

                    <div class="part" id="summary">
                        <h2>Summary</h2>
                        <ul>
                            <li><a href="#try">Try this framework</a></li>
                            <li><a href="#tweeter">Tweeter</a></li>
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

                    <div class="part" id="try">
                        <h2>Try this framework</h2>
                        <p>Try this framework by adding your name in it.</p>
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="row text-center">
                                    <h4>Add your name as a visitor</h4>
                                </div>
                                <form action="$adding_name_route" method="post">
                                    <div class="mb-2 row">
                                        <label for="name" class="col-auto col-form-label">Add your name</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="visitor" id="name" placeholder="Enter your name" required>
                                        </div>
                                    </div>
                                    <div class="mb-2 row">
                                        <label for="age" class="col-auto col-form-label">Age</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="age" id="age" placeholder="Enter your age" required>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <button type="submit" class="btn btn-dark mx-3 col-4">Add your name</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <p class="m-0">People that added their names:</p>
                        <div class="row p-2">
                            <table class="table table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Age</th>
                                        <th scope="col">Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    $people_html
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="part" id="tweeter">
                        <h2><a href="https://tweeeeter.000webhostapp.com/">Tweeter</a></h2>
                        <p>
                            Tweeter is a twitter like app built using an early version of this framework it allows 
                            users to post short messages, known as "tweets", and interact with others through 
                            likes and checking out their tweets. The app features a real-time feed of the recent 
                            tweets from users.
                            <br />
                            <i>
                                (<a href="https://tweeeeter.000webhostapp.com/">check it out live</a> or the <a href="https://github.com/you97ssef/Tweeter">the repo of this app</a>)
                            </i>
                        </p>
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
                                <a href="https://github.com/you97ssef/Helloquent">
                                    Helloquent</a
                                >, an ORM tool specifically built for the framework. For
                                further details, refer to the
                                <b>Helloquent</b> documentation in this link
                                <a href="https://github.com/you97ssef/Helloquent">
                                    https://github.com/you97ssef/Helloquent</a
                                >. <br />
                                Models should be stored in the
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
                    <hr />
                    <div class="text-center">© Yaravel 2023 - by <a href="https://youssefb.netlify.app/">Youssef</a></div>
                </main>
            </section>
        HTML;
    }
}
