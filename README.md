# md-cms

md-cms is a minimal file-based content-management-system (CMS), consisting of Markdown files and a very slim PHP core. 

Features:
* Dynamic rendering of Markdown files via HTML template
* Utility-first styling with [tailwindcss](http://tailwindcss.com)
* Lightweight interactivity using [Alpine.js](https://alpinejs.dev)
* Development server with auto-reload
* Git-based auto-deployment feature

**Note:** [Parsedown 1.7.4](https://github.com/erusev/parsedown) requires PHP <8.1

## Gettings started

### Setup

```bash
yarn install
```

### Run

```bash
yarn dev
```

The website is now served at [http://localhost:3000/](http://localhost:3000/).

### Build

```bash
yarn build
```

## Auto-Deployment

### Enable the feature

The auto-deployment feature enables webhook actions, e.g. triggered by GitHub, to pull latest changes from a git repository onto the web server.

Therefore, create a `.env` file in document root:

```env
# A long, secret and HTML-safe string
DEPLOY_SECRET=<YOUR_DEPLOYMENT_SECRET>
# Optional: Whitelist IP addresses, e.g. only accept webhooks from localhost
DEPLOY_WEBHOOK_IPS=127.0.0.1,
```

Each request to `/deploy/<YOUR_DEPLOYMENT_SECRET>` will now trigger `git pull`, `git submodule sync`, followed by `git submodule update`.

### Add deployment key

**Note:** Make sure the following SSH configuration belongs to the user used by the webserver, like `web`, e.g. by changing user with `sudo su web`.

1. Create an SSH key on the server as deployment key:

```sh
ssh-keygen -t ed25519 -a 420 -f ~/.ssh/your.project.ed25519 -C "Deployment key for your.project"
```

2. Add a SSH config to `~/.ssh/config`, e.g. for GitHub:

```
Host your_project
    Hostname github.com
    IdentityFile  ~/.ssh/your.project.ed25519
    IdentitiesOnly yes
```

3. Add SSH public key as deployment key to git platform

4. Clone the repository at the server using the generated deployment key:

```
git clone git@your_project:user/your.project.git'
```

5. Add a webhook to your git platform, specifying the `/deploy/<YOUR_DEPLOYMENT_SECRET>` endpoint.

6. Sit back and enjoy.