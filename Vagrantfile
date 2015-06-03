# Check to determine whether we're on a windows or linux/os-x host,
# later on we use this to launch ansible in the supported way
# source: https://stackoverflow.com/questions/2108727/which-in-ruby-checking-if-program-exists-in-path-from-ruby
def which(cmd)
    exts = ENV['PATHEXT'] ? ENV['PATHEXT'].split(';') : ['']
    ENV['PATH'].split(File::PATH_SEPARATOR).each do |path|
        exts.each { |ext|
            exe = File.join(path, "#{cmd}#{ext}")
            return exe if File.executable? exe
        }
    end
    return nil
end

PROJECT_BASE_PATH = "/var/www/workspace/symfonycrm/"
PROJECT_SRC_PATH  = PROJECT_BASE_PATH

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    config.ssh.private_key_path = ["~/.vagrant.d/insecure_private_key", "./provision/ansible/files/rsa_private_key"]

    config.vm.provider :virtualbox do |vb|
        vb.customize [
        	"modifyvm", :id,
        	 "--natdnshostresolver1", "on",
        	 "--memory", "1024"
        ]
    end

    config.vm.define 'symfonycrm' do |node|
        # VirtualBox specific options
        node.vm.box = "debian-jessie"
        node.vm.box_url = "https://github.com/holms/vagrant-jessie-box/releases/download/Jessie-v0.1/Debian-jessie-amd64-netboot.box"

        node.vm.hostname = 'symfonycrm'
        node.vm.network "private_network", ip: '192.168.56.182'
        node.vm.network "forwarded_port", guest: 80, host: 8002

        node.vm.synced_folder "./", PROJECT_SRC_PATH, create: true
    end

    #############################################################
    # Ansible provisioning (you need to have ansible installed)
    #############################################################

    if which('ansible-playbook')
        config.vm.provision "ansible" do |ansible|
            ansible.playbook = "provision/ansible/playbook.yml"
            ansible.inventory_path = "provision/ansible/inventories/dev"
            ansible.limit = 'all'
            ansible.extra_vars = {
                base_path: PROJECT_BASE_PATH,
                src_path: PROJECT_SRC_PATH,
                cpd: "internal"
            }
        end
    else
        config.vm.provision :shell, privileged: false, path: "provision/ansible/windows.sh", args: [PROJECT_BASE_PATH, PROJECT_SRC_PATH]
    end

end
