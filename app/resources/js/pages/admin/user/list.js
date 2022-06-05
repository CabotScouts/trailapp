import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import Frame, { Container } from '@/layouts/admin/frame';
import ListItem from '@/components/admin/list-item';
import { Button, ButtonBar } from '@/components/admin/button-bar';
import { PencilIcon } from '@heroicons/react/solid';

export default function List({ users }) {
  return (
    <Frame title="Users">
      <ButtonBar>
        <Button href={ route('add-user') }>Add User</Button>
      </ButtonBar>

      <Container>
        { users.map((u) => <ListItem key={ u.id }>
          <div className="flex-grow pr-5">
            <p className="text-xl text-medium">{ u.username }</p>
          </div>
          <div className="flex-none flex items-center">
          <Link href={ route('edit-user', u.id) }>
              <div className="w-8 rounded-xl text-center text-neutral-100 text-sm p-2 bg-emerald-600">
                <PencilIcon />
              </div>
            </Link>
          </div>
        </ListItem>) }

        { (users.length === 0) &&
          <div className="p-5 text-center">
            <p className="text-medium text-xl">No users - if you're seeing this you must be the root user, congratulations!</p>
          </div>
        }
      </Container>
    </Frame>
  )
}
