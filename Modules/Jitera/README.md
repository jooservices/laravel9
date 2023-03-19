# APIs

Prefix `/v1/users`

Naming prefix `jitera.users.`

## **Context**

In this context, all APIs used without authentication. Mean
- Request `user` is not defined
  - It'll be declared as an parameter in the API

## **Definitions**

- `follower user` : Who asking to follow another user
- `followed user` : Who being `followed` by `follower` user

## Packages
- In this Test, i'm using Module package for splitting the code into modules

## APIs
### `{follower_user_id}` follow `{user}` 
`POST api/v1/users/{user}/follow`

Payload

`'follower_user_id' => 'required|exists:users,id',`

### `{follower_user_id}` unfollow `{user}`

`POST api/v1/users/{user}/unfollow`

Payload

`'follower_user_id' => 'required|exists:users,id',`

### Get followers of {users}

`GET api/v1/users/{user}/followings`
