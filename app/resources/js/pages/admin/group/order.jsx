import React from 'react';
import { useForm } from '@inertiajs/react';
import { DndContext, useDraggable, useDroppable } from '@dnd-kit/core';
import Frame, { Container } from '@/layouts/admin/frame';
import ListItem from '@/components/admin/list-item';
import { Button, ButtonBar } from '@/components/admin/button-bar';
import { __ } from '@/composables/translations';

export default function List({ groups }) {
  const { data, setData, post, processing, errors, reset } = useForm({
  });

  const submit = (e) => {
    e.preventDefault();
    post(route('order-groups'));
  };

  return (
    <Frame title={__("Reorder Groups")}>
      <ButtonBar>
        <form onSubmit={submit}>
          <Button processing={processing}>{__("Save Order")}</Button>
        </form>
      </ButtonBar>

      <DndContext>
        <Container>
          {groups.map((g) => <ListItem key={g.id}>
            <div className="flex-grow pr-5">
              <p className="text-xl text-medium">{g.name}</p>
            </div>
          </ListItem>)}

          {(groups.length === 0) &&
            <div className="p-5 text-center">
              <p className="text-medium text-xl">{__("No groups")}</p>
            </div>
          }
        </Container>
      </DndContext>
    </Frame>
  )
}
