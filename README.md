# Random Gym

College project made for the summer programming workshop. Reduced gym administration system.

## Installation

1. Download the virtual machine as ova from [here](https://www.turnkeylinux.org/download?file=turnkey-lamp-15.1-stretch-amd64.ova)
2. Import it into VirtualBox
3. Start the created VM and setup your credentials
4. Close the easy setup and log into the system as root
5. Run `cd /var; rm -r www; git clone https://github.com/mrnkr/workshop-project www; cd www`
6. Run `chmod +x postclone.sh`
7. Run `./postclone.sh`
8. Enter your mysql username and password as the script asks for them
9. You're ready to go! Check out the site on your browser! 😃

> Some data in within the database dump does not comply with the validation set up in either the front or backend, that is because it was auto generated using the [dummy-filler](https://github.com/mrnkr/random-data-generator)
