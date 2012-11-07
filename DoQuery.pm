package DoQuery;

require Exporter;
@ISA = qw(Exporter);
@EXPORT = qw(DoQuery);

use DBI;

use vars qw($dbh);
my $connected = 0;
my $database = "";

sub Connect {
    #
    # Connect to database if not yet connected; sets
    # global variable $dbh to the connection handle
    #
    $db = shift;
    $username = shift;
    $password = shift;
    if ($db) { $database = $db; }
    if (!$connected) {
        $dbh = DBI->connect("dbi:mysql:dbname=$database", $username, $password);
	$connected = 1;
    }
    return $dbh;
}

sub DoQuery {
    my $query = shift;
    Connect();
    my $sth = $dbh->prepare($query);
#  print STDERR "DoQuery: $query\n";
    if (!$sth) {
	my $errmsg = "SQL Error: " . $dbh->errstr . "\n" .
	    " on query: \"$query\"\n";
	if ($verbose) {
	    # In verbose mode, we print the error message to stderr
	    # in addition to dying with it, in case the caller traps
	    # the die with an 'eval', which might prevent the error
	    # message from being visible.
	    print STDERR $errmsg;
	}
	die $errmsg;
    }
    $sth->execute();
    if ($verbose) { print STDERR "did query: \"$query\"\n"; }
    return $sth;
}

1;
