class Asimov < Formula
  desc "Automatically exclude development dependencies from Apple Time Machine backups "
  homepage "https://github.com/stevegrunwell/asimov"
  url "https://github.com/stevegrunwell/asimov/archive/v0.2.0.tar.gz"
  sha256 "2efb456975af066a17f928787062522de06c14eb322b2d133a8bc3a764cc5376"
  revision 0

  # Setup HEAD support (install with --HEAD)
  head "https://github.com/stevegrunwell/asimov.git", :branch => "develop"

  # No bottling necessary
  bottle :unneeded

  # Define the installation steps
  def install
    # Install the application
    bin.install buildpath/"asimov"
  end

  # Define launch agent plist options (launch automatically, but also allow manual startup)
  plist_options :startup => true, :manual => "asimov"

  # Define the agent plist contents
  def plist; <<~EOS
    <?xml version="1.0" encoding="UTF-8"?>
    <!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
    <plist version="1.0">
        <dict>
            <key>Label</key>
            <string>#{plist_name}</string>
            <key>Program</key>
            <string>#{opt_bin}/asimov</string>
            <key>StartInterval</key>
            <!-- 24 hours = 60 * 60 * 24 -->
            <integer>86400</integer>
        </dict>
    </plist>
  EOS
  end

  # Define tests to run
  test do
    # Test that the binary exists
    assert File.file?(bin/"asimov"), "asimov binary not found"

    # Test that the symlink exists
    assert File.file?("/usr/local/bin/asimov"), "asimov binary symlink not found in /usr/local/bin"

    # Test that the launch agent plist exists
    assert File.file?(plist_path), "asimov plist not found in "+plist_path
  end
end
