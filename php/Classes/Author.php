<?php
namespace ByrneIndia\ObjectOriented;
require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");
use http\Encoding\Stream\Inflate;
use Ramsey\Uuid\Uuid;

/**
 * Author
 * Phase 1 OOP
 * @author India Byrne <byrrneindia@gmail.com>
 **/
class Author {
	use ValidateUuid;

	private $authorId;
	private $authorActivationToken;
	private $authorAvatarUrl;
	private $authorEmail;
	private $authorHash;
	private $authorUsername;

	/**
	 * *Constructor for this author.
	 * @param int Uuid $newAuthorId new user id.
	 * @param string $newAuthorActivationToken new activation token.
	 * @param string $newAuthorAvatarURl new Author Avatar.
	 * @param string $newAuthorEmail string containing email
	 * @param string $newAuthorHash containing password hash.
	 * @param string $newAuthorUsername string containing username.
	 */
	public function __construct($newAuthorId, string $newAuthorActivationToken, $newAuthorAvatarUrl, $newAuthorEmail, $newAuthorHash, $newAuthorUsername)
	{
		try {
			$this->setAuthorId($newAuthorId);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorAvatarURL($newAuthorAvatarUrl);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUsername($newAuthorUsername);
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * Accessor method for Author id.
	 *
	 * @return Uuid value of Author id or null.
	 **/

	public function getAuthorId() : Uuid {
		return($this->authorId);
	}

	/**
	 * Mutator method for Author id.
	 *
	 * @param Uuid string $newAuthorId new value of Author id.
	 * @throws \RangeException if $newAuthorId is not positive.
	 * @throws \TypeError if $newAuthorId is not a integer.
	 **/

	public function setAuthorId( $newAuthorId): string
	{
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the Author id
		$this->authorId = $uuid;
	}

	/**
	 * accessor method for author activation token.
	 *
	 * @return string value of the activation method.
	 **/

	public function setAuthorActivationToken(?string $newAuthorActivationToken): void {
		if ($newAuthorActivationToken == null) {
			$this->authorActivationToken = null;
			return;
		}

		$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
		if(ctype_xdigit($newAuthorActivationToken) === false) {
			throw(new\RangeException("User Activation not valid."));
		}

		if(strlen($newAuthorActivationToken) === false) {
			throw(new\RangeException("User Activation must be 32."));
		}
		$this->authorActivationToken = $newAuthorActivationToken;
	}

	/**
	 * mutator method for author activation token.
	 *
	 * @param string  Uuid $newAuthorActivationToken
	 * @throws \InvalidArgumentException if the token is not a string or insecure.
	 * @throws \RangeException if token does not have enough characters.
	 * @throws \TypeError if activation token is not a string.
	 **/

	public function setAuthorAvatarURL (string $newAuthorAvatarURL): string
	{
		if ($newAuthorAvatarURL === null) {
			$this->authorAvatarUrl = null;
			return;
		}

		$newAuthorAvatarURL = trim($newAuthorAvatarURL);
		$newAuthorAvatarURL = filter_var($newAuthorAvatarURL, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES_);
		if (empty($newAuthorAvatarURL) === true) {
			throw(new  \InvalidArgumentException("Avatar URL is unsecure or empty."));
		}

		if (strlen($newAuthorAvatarURL) > 255) {
			throw (new\RangeException("Avatar is too large."));
		}

		$this->authorAvatarUrl = $newAuthorAvatarURL;
	}

	/**
	 * mutator method for email
	 *
	 * @param string $newAuthorEmail new value of email.
	 * @throws \InvalidArgumentException if $newAuthorEmail is not valid or insecure.
	 * @throws \RangeException if $newAuthorEmail is > 140 characters.
	 * @throws \TypeError if $newEmail is not a string.
	 **/

	public function setAuthorEmail(string $newAuthorEmail): string  {
		// verify the email content is secure
		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
		if(empty($AuthorEmail) === true) {
			throw(new \InvalidArgumentException("Author email is empty or insecure."));
		}

		// verify the email content will fit in the database
		if(strlen($newAuthorEmail) > 140) {
			throw(new \RangeException("Author email is too large."));
		}

		// store the email content
		$this->authorEmail = $newAuthorEmail;
	}

	/**
	 * accessor method for authorHash
	 *
	 * @return string for authorHash
	 **/

	public function getAuthorHash():string {
		return($this-> authorHash);
	}

	/**
	 * mutator method for authorHash
	 *
	 * @param string $newAuthorHash value of new author hashed password.
	 * @throws \InvalidArgumentException if the hash is not secure.
	 * @throws \RangeException if hash is not 140 characters.
	 * @throws \TypeError if author has is not a string.
	 **/

	public function setAuthorHash(string $newAuthorHash) : void {
		//enforce has format.
		$newAuthorHash = trim($newAuthorHash);
		$newAuthorHash = strtolower($newAuthorHash);
		if (empty($newAuthorHash) === true) {
			throw (new\InvalidArgumentException("Author password has empty or insecure."));
		}
		//enforce string
		if(!ctype_xdigit($newAuthorHash)) {
			throw(new \InvalidArgumentException("Author password hash is empty or insecure."));
		}

		//enforce 140 characters.
		if(strlen($newAuthorHash) !== 140) {
			throw(new\RangeException("Author hash must be 140 characters."));
		}
		//store the hash
		$this->authorHash=$newAuthorHash;
	}

	/**
	 * mutator method for Username
	 *
	 * @param string $newAuthorUsername
	 */
	public function setAuthorUsername(string $newAuthorUsername): string {
		// verify the at handle is secure
		$newAuthorUsername = trim($newAuthorUsername);
		$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorUsername) === true) {
			throw(new \InvalidArgumentException("Username is empty or insecure"));
		}
		// verify username can fit within database.
		if(strlen($newAuthorUsername) > 32) {
			throw(new \RangeException("Username is too large"));
		}
		// store the Username
		$this->authorUsername = $newAuthorUsername;

	}
	/** Insert this author. */

	public function insert(\PDO $pdo)
	{

		// create query template
		$query = "INSERT INTO author(authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername) 
                VALUES (:authorId, :authorAvatarUrl, :authorActivationToken, :authorEmail, :authorHash, :authorUsername)";
		$statement = $pdo->prepare($query);

		// bind member variables to the place holders in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorActivationToken" => $this->authorActivationToken,
			"authorAvatarUrl" => $this->authorAvatarUrl,
			"authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" => $this->authorUsername];
		$statement->execute($parameters);
	}

	/* @param \PDO $pdo PDO connection object.
	 * @throws \PDOException mySQL related errors occur.
	 * @throws \TypeError if $pdo is not a PDO connection object.
	 */

	/** Delete this author. */

	public function delete (\PDO  $pdo): void
	{
		// create query template
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * @param \PDO $pdo PDO connection object.
	 * @throws \PDOException when mySQL related errors occur.
	 * @throws \TypeError if $pdo is not a PDO connection object.
	 **/
	/**Updates the author.*/
	public function update (\PDO $pdo): string {
		// create query temp.

		$query = "UPDATE author SET authorId = :authorId, authorActivationToken = :authorActivationToken, 
    	        authorAvatarUrl = :authorAvatarUrl, authorEmail = :authorEmail, authorHash = :authorHash, 
    	        authorUsername = :authorUsername WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorActivationToken" => $this->authorActivationToken,
			"authorAvatarUrl" => $this->authorAvatarUrl, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash,
			"authorUsername" => $this->authorUsername];
		$statement->execute($parameters);
	}

	/** @param \PDO $pdo PDO connection object.
	 * @throws \PDOException when mySQL related errors occur.
	 * @throws \TypeError if $pdo is not a PDO connection object
	/* Gets the author.**/

	public static function getAuthorByAuthorId(\PDO $pdo, $authorId) : ?author
	{

		// sanitize the authorID before searching
		try {
			$authorId = self::validateUuid($authorId);
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query temp.
		$query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername 
		            FROM author WHERE authorId = authorId";
		$statement = $pdo->prepare($query);
		//bind the author Id to the place holder in the template
		$parameters = ["authorId" => $authorId->getBytes()];
		$statement->execute($parameters);

		try {
			$author = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if ($row !== false) {
				$author = new author($row["authorId"], $row["authorActivationToken"], $row["authorAvatarUrl"],
					$row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
			}
		} catch (\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($author);
	}

	public static function getAllauthors(\PDO $pdo): \SPLFixedArray
	{
		// create query template
		$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername  FROM author";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of tweets
		$authors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while (($row = $statement->fetch()) !== false) {
			try {
				$author = new author($row["authorId"], $row["authorAvatarUrl"], $row["authorActivationToken"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
				$authors[$authors->key()] = $author;
				$authors->next();
			} catch (\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($authors);
	}

	/**
	 * Formats state variables for JSON serialization.
	 *
	 * @return array resulting state variables to serialize.
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["authorId"] = $this->authorId->toString();
		unset($fields["authorActivationToken"]);
		unset($fields["authorHash"]);
		return ($fields);

	}
}