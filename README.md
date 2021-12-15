<!-- markdownlint-disable no-inline-html -->
<p align="center">
    <img src="https://leafphp.dev/logo-circle.png" height="100"/>
    <br><br>
</p>

# Aloe CLI

[![Latest Stable Version](https://poser.pugx.org/leafs/leaf/v/stable)](https://packagist.org/packages/leafs/leaf)
[![Total Downloads](https://poser.pugx.org/leafs/leaf/downloads)](https://packagist.org/packages/leafs/leaf)
[![License](https://poser.pugx.org/leafs/leaf/license)](https://packagist.org/packages/leafs/leaf)

Aloe is a CLI tool that comes with Leaf API and Leaf MVC v2 upwards. It ties into the Leaf console tool and totally replaces all it's functionality. Aloe exists at the root of your application in the `leaf` script and provides a number of helpful commands that can assist you while you build your application. To view all available commands, you can use the `list` command or call `leaf`.

```sh
php leaf list
# or
php leaf
```

Every command also includes a "help" screen which displays and describes the command's available arguments and options. To view a help screen, precede the name of the command with help:

```sh
php leaf help db:migrate
```

## Interact (REPL)

Aloe comes with aloe-interact which is basically powerful REPL powered by [PSY Shell](https://github.com/bobthecow/psysh). Interact allows you to interact with your app, access variables and methods in your Leaf app, run and rollback migrations, perform database operations and so much more. You can access interact on aloe like this:

```sh
php leaf interact
```

## Writing Commands

Aside all the commands provided by aloe, you can also create your own commands and run them through the aloe cli. Aloe CLI allows you to directly generate commands to run in the CLI.

### Generating Commands

To create a new command, you may use the `g:command` aloe command. This command will create a new command class in the default commands directory.

The default directory for commands in Leaf API and Leaf MVC is `App\Console`, with skeleton, you're free to decide where to place your commands.

```sh
php leaf g:command SendMail
```

Aloe can also generate namespaced commands directly for you. You don't have to manually set namespaces as done with other CLI tools.

```sh
php leaf g:command mail:send
```

If you want to, you can even generate the command by it's name instead of it's class. Aloe is smart enough to differentiate them.

```sh
php leaf g:command shutdown 
```

### Command Structure

After generating your command, you should start writing what to execute once the command is called. Aloe smartly generates a command name for you, even if you create the command using the class name, however, if it doesn't match what you need, you can always change it.

With the `mail:send` example above, Aloe wil generate `App\Console\MailSendCommand`, in this file, we'll have something that looks like this:

```php
<?php
namespace App\Console;

use Aloe\Command;

class ExampleCommand extends Command
{
    protected static $defaultName = "mail:send";
    public $description = "mail:send command's description";
    public $help = "mail:send command's help";

    public function handle()
    {
        $this->comment("mail:send command's output");
    }
}

```

We can add an argument to find the user to send the email to, and output a message while sending the email.

```php
public function config()
{
    $this->setArgument("user", "required");
}

public function handle()
{
    $user = $this->argument('user');

    $this->comment("Sending email to $user");

    $success = \CustomEmailHandler::send($user);

    if ($success) {
        $this->info("Email sent successfully");
    } else {
        $this->error("Couldn't send email, pls try again");
    }
}
```

### Registering Commands

By default, aloe cli registers all commands generated, however, if you have a command you want to register manually, or commands from a package which need to use Aloe, you can also add them pretty easily.

Simply locate the `aloe` file in the root directory of your project, open it up and find a commented section talking about custom commands.

```php
/*
|--------------------------------------------------------------------------
| Add custom command
|--------------------------------------------------------------------------
|
| If you have a new command to add to Leaf
|
*/
$aloe->register(\App\Console\ExampleCommand::class);
```

An example command has already been registered, so you can follow this example. Simply call the `register` method. You can also pass in an array of commands to register, as such, a custom package with a couple of commands to register can simply return an array of all those commands.

```php
$aloe->register([
    \App\Console\AppCommand::class,
    CustomPackage::commands(),
]);
```

## 💬 Stay In Touch

- [Twitter](https://twitter.com/leafphp)
- [Join the forum](https://github.com/leafsphp/leaf/discussions/37)
- [Chat on discord](https://discord.com/invite/Pkrm9NJPE3)

## 📓 Learning Leaf 3

- Leaf has a very easy to understand [documentation](https://leafphp.dev) which contains information on all operations in Leaf.
- You can also check out our [youtube channel](https://www.youtube.com/channel/UCllE-GsYy10RkxBUK0HIffw) which has video tutorials on different topics
- We are also working on codelabs which will bring hands-on tutorials you can follow and contribute to.

## 😇 Contributing

We are glad to have you. All contributions are welcome! To get started, familiarize yourself with our [contribution guide](https://leafphp.dev/community/contributing.html) and you'll be ready to make your first pull request 🚀.

To report a security vulnerability, you can reach out to [@mychidarko](https://twitter.com/mychidarko) or [@leafphp](https://twitter.com/leafphp) on twitter. We will coordinate the fix and eventually commit the solution in this project.

### Code contributors

<table>
	<tr>
		<td align="center">
			<a href="https://github.com/mychidarko">
				<img src="https://avatars.githubusercontent.com/u/26604242?v=4" width="120px" alt=""/>
				<br />
				<sub>
					<b>Michael Darko</b>
				</sub>
			</a>
		</td>
        <td align="center">
			<a href="https://github.com/pjotrsavitski">
				<img src="https://avatars.githubusercontent.com/u/518331?v=4" width="120px" alt=""/>
				<br />
				<sub>
					<b>Pjotr Savitski</b>
				</sub>
			</a>
		</td>
        <td align="center">
			<a href="https://github.com/Aminur670">
				<img src="https://avatars.githubusercontent.com/u/32174602?v=4" width="120px" alt=""/>
				<br />
				<sub>
					<b>Aminur Rahaman</b>
				</sub>
			</a>
		</td>
	</tr>
</table>

## 🤩 Sponsoring Leaf

Your cash contributions go a long way to help us make Leaf even better for you. You can sponsor Leaf and any of our packages on [open collective](https://opencollective.com/leaf) or check the [contribution page](https://leafphp.dev/support/) for a list of ways to contribute.

And to all our existing cash/code contributors, we love you all ❤️

### Cash contributors

<table>
	<tr>
		<td align="center">
			<a href="https://opencollective.com/aaron-smith3">
				<img src="https://images.opencollective.com/aaron-smith3/08ee620/avatar/256.png" width="120px" alt=""/>
				<br />
				<sub><b>Aaron Smith</b></sub>
			</a>
		</td>
		<td align="center">
			<a href="https://opencollective.com/peter-bogner">
				<img src="https://images.opencollective.com/peter-bogner/avatar/256.png" width="120px" alt=""/>
				<br />
				<sub><b>Peter Bogner</b></sub>
			</a>
		</td>
		<td align="center">
			<a href="#">
				<img src="https://images.opencollective.com/guest-32634fda/avatar.png" width="120px" alt=""/>
				<br />
				<sub><b>Vano</b></sub>
			</a>
		</td>
	</tr>
</table>

## 🤯 Links/Projects

- [Aloe CLI](https://leafphp.dev/aloe-cli/)
- [Leaf Docs](https://leafphp.dev)
- [Leaf MVC](https://mvc.leafphp.dev)
- [Leaf API](https://api.leafphp.dev)
- [Leaf CLI](https://cli.leafphp.dev)
