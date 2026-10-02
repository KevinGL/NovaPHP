<?php

namespace App\Models;

class User
{
	/** @var int @Column(type="int", primary_key=true, name="id") */
    private int $id;

	/** @var string @Column(type="string", length=255, name="username") */
	private string $username;

	/** @var string @Column(type="string", length=255, name="email") */
	private string $email;

	/** @var string @Column(type="string", length=255, name="password") */
	private string $password;

	/** @var string @Column(type="text", name="description") */
	private string $description;

	/** @var \DateTimeImmutable @Column(type="date", name="created_at") */
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

	public function getDescription(): string
	{
		return $this->description;
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

	public function setDescription(string $description): self
	{
		$this->description = $description;
		return $this;
	}

	public function setCreatedAt(\DateTimeImmutable $createdAt): self
	{
		$this->createdAt = $createdAt;
		return $this;
	}
}