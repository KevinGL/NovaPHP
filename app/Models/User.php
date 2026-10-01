<?php

namespace App\Models;

class User
{
	/** @var int @Column(type="int", primary_key=true) */
    private int $id;

	/** @var string @Column(type="string", length=255) */
	private string $username;

	/** @var string @Column(type="string", length=255) */
	private string $email;

	/** @var string @Column(type="string", length=255) */
	private string $password;

	/** @var string @Column(type="text") */
	private string $descrition;

	/** @var \DateTimeImmutable @Column(type="date") */
	private \DateTimeImmutable $createdAt;

	public function getId(): int
	{
		return $this->id;
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function getDescrition(): string
	{
		return $this->descrition;
	}

	public function getCreatedAt(): \DateTimeImmutable
	{
		return $this->createdAt;
	}

	public function setId(int $id): self
	{
		$this->id = $id;
		return $this;
	}

	public function setUsername(string $username): self
	{
		$this->username = $username;
		return $this;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;
		return $this;
	}

	public function setPassword(string $password): self
	{
		$this->password = $password;
		return $this;
	}

	public function setDescrition(string $descrition): self
	{
		$this->descrition = $descrition;
		return $this;
	}

	public function setCreatedAt(\DateTimeImmutable $createdAt): self
	{
		$this->createdAt = $createdAt;
		return $this;
	}
}