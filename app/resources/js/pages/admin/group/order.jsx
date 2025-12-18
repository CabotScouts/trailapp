import React, { useState } from 'react';
import { useForm } from '@inertiajs/react';
import {
  DndContext,
  DragOverlay,
  closestCenter,
  KeyboardSensor,
  PointerSensor,
  useSensor,
  useSensors,
} from '@dnd-kit/core';
import {
  arrayMove,
  SortableContext,
  sortableKeyboardCoordinates,
  verticalListSortingStrategy,
} from '@dnd-kit/sortable';

import Frame, { Container } from '@/layouts/admin/frame';
import ListItem from '@/components/admin/list-item';
import { Button, ButtonBar } from '@/components/admin/button-bar';
import { __ } from '@/composables/translations';

export default function List({ groups }) {
  const { data, setData, post, processing, errors, reset } = useForm({
  });

  const [activeId, setActiveId] = useState(null);
  const [items, setItems] = useState([1, 2, 3]);
  const sensors = useSensors(
    useSensor(PointerSensor),
    useSensor(KeyboardSensor, {
      coordinateGetter: sortableKeyboardCoordinates,
    })
  );

  const submit = (e) => {
    e.preventDefault();
    post(route('order-groups'));
  };

  function handleDragStart(event) {
    const { active } = event;

    setActiveId(active.id);
  }

  function handleDragEnd(event) {
    const { active, over } = event;

    if (active.id !== over.id) {
      setItems((items) => {
        const oldIndex = items.indexOf(active.id);
        const newIndex = items.indexOf(over.id);

        return arrayMove(items, oldIndex, newIndex);
      });
    }
  }

  function SortableItem({ group }) {
    return (
      <ListItem key={group.id} id={group.id}>
        <div className="flex-grow pr-5">
          <p className="text-xl text-medium">{group.name}</p>
        </div>
      </ListItem>
    )
  }

  return (
    <Frame title={__("Reorder Groups")}>
      <ButtonBar>
        <form onSubmit={submit}>
          <Button processing={processing}>{__("Save Order")}</Button>
        </form>
      </ButtonBar>

      <Container>
        {(groups.length === 0) &&
          <div className="p-5 text-center">
            <p className="text-medium text-xl">{__("No groups")}</p>
          </div>
        }

        {(groups.length > 0) &&
          <DndContext
            sensors={sensors}
            collisionDetection={closestCenter}
            onDragStart={handleDragStart}
            onDragEnd={handleDragEnd}
          >
            <SortableContext
              items={items}
              strategy={verticalListSortingStrategy}
            >
              {groups.map((g) => <SortableItem group={g} />)}
            </SortableContext>

            <DragOverlay>

            </DragOverlay>
          </DndContext>
        }
      </Container>

    </Frame>
  )
}
