#!/bin/env ruby
# Copyright 2011 Ryan Rix <ry@n.rix.si>
# GPL
# Interface to dump MAC address CSV for PAMELA

require 'rubygems'
require 'cgi'

cgi = CGI.new

puts "Content-type: text/html \r\n\r\n"

if cgi['macaddress'].to_s and cgi['name'].to_s

	File.open("/var/www/html/mac_log.csv", 'a') { |f| f.write( cgi['macaddress'].to_s.downcase + "," + 
		                                                   cgi['name'].to_s + "\n" ) }

end
