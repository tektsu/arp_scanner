#!/usr/bin/env ruby

require "active_record"
require "optparse"
require "rubygems"

# Command line arguments
options = {};
OptionParser.new { |opts|
	opts.banner = "Usage: pamela-scanner.rb --interface=en0"

	options[:interface] = "en0"
	opts.on("i", "--interface=interface", "Network Interface") { |interface|
		options[:interface] = interface
	}

}.parse!

puts sprintf("arp-scan -R --interface=%s --localnet", options[:interface])

# Open the database
ActiveRecord::Base::establish_connection(
	:adapter  => "mysql2",
	:host     => "ad7wy.org",
	:database => "ad7wy_hslpamela",
	:username => "ad7wy_hsl",
	:password => "password")

class Mac < ActiveRecord::Base
end

class Log < ActiveRecord::Base
end

# Scan the network for mac addresses
macs = {};
IO.popen(sprintf("arp-scan -R --interface=%s --localnet", options[:interface])) { |stdin|
	stdin.each { |line| 
		next if line !~ /^([\d\.]+)\s+([[:xdigit:]:]+)\s/;
		macs[$2] = $1;
	}
}

# Scan the existing macs and update each record as necessary
Mac.find(:all).each { |entry|
	mac = entry.mac
	ip = entry.ip
	if macs.has_key?(mac)
		if ! entry.active || ! entry.since
			entry.since = Time.now
			Log.new(:mac => mac, :ip => ip, :action => "activate").save
		end
		entry.active = 1
		entry.ip = ip
		entry.refreshed = Time.now
		entry.save
		macs.delete(mac)
		next
	end

	# Entry is no longer current
	entry.active = 0
	entry.save
	Log.new(:mac => mac, :ip => ip, :action => "deactivate").save
}

# Add entries for any macs not already in the db
macs.each { |mac, ip|
	Mac.new(:mac => mac, :ip => ip, :active => 1, :since => Time.now, :refreshed => Time.now).save
	Log.new(:mac => mac, :ip => ip, :action => "activate").save
}

